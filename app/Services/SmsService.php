<?php

namespace App\Services;

use GuzzleHttp\Client;

class SmsService
{
    public static function kavenegar($phone, $token , $template = 'verify' , $token2 = '' , $token3 = '')
    {
        $url = "https://api.kavenegar.com/v1/" . config('services.kavenegar.token') . "/verify/lookup.json?receptor=$phone&token=$token&token2=$token2&token3=$token3&template=$template";
        $client = new Client();
        $response = $client->get($url);
    }
}
