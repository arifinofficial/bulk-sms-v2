<?php

namespace App\Http\Traits;

trait SendSmsTrait
{
    public static function Send(string $apiUsername, string $apiPassword, string $msisdnSender, string $msisdn, string $formattedText, string $boradcastId, string $encryptKey)
    {
        $username = urlencode($apiUsername);
        $password = urlencode($apiPassword);
        $msisdn_sender = urlencode($msisdnSender);
        $destination = urlencode($msisdn);
        $message = urlencode($formattedText);
        $route_type= urlencode('reg');
        $dr_url = urldecode(env('URL_SMS_DRURL')."/$boradcastId/$encryptKey");

        $url = env('URL_SMS_ENDPOINT')."?msg_type=txt&username={$username}&password={$password}&msisdn_sender={$msisdn_sender}&msisdn={$destination}&message={$message}&route_type={$route_type}&dr_url={$dr_url}";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}
