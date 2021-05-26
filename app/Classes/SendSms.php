<?php

namespace App\Classes;
// require SDK here
use AfricasTalking\SDK\AfricasTalking;

class SendSms
{
    public function sendSms($phone, $message)
    {
        $username = "myvoice";
        // $apiKey   = "c8da900278d0a2e8407f10d6e78022caf693bc2de0bf1100c6127cc703d22277";
        $apiKey   = "28ab1ac910b7c39f78eaa1bb91b3bd10270c1c800ece16aae18687be9a22c5eb";
        // Initialize the SDK
        $AT       = new AfricasTalking($username, $apiKey);
        //Get the airtime service
        $sms  = $AT->sms();
        $results = $sms->send([
            "from" => '',
            "to"  => $phone,
            "message" => $message,
        ]);
        if($results['data']->SMSMessageData->Recipients[0]->status == "Success" || $results['data']->SMSMessageData->Recipients[0]->status == "Sent")
        {
            return 'success';
        }else{
            return 'Failed';
        }
    }
}