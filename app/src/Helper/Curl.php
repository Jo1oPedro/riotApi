<?php

namespace App\Helper;

use stdClass;

class Curl
{
    public function request(string $url, string $method, $jsonDecode = true): array|stdClass|string
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_CUSTOMREQUEST => $method
        ]);
        $response = ($jsonDecode === true) ? json_decode(curl_exec($curl)) : curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}