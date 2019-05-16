<?php

namespace app\models;

use yii\base\Model;

class Notification extends Model
{
    public static function subscribe($pushToken, $areaIds)
    {
        $fcm_key = getenv('FCM_KEY');
        $sender_id = getenv('FCM_SENDER_ID');
        $client = new \Fcm\FcmClient($fcm_key, $sender_id);

        // Subscribe $device_id to a topic
        foreach ($areaIds as $key => $value) {
            $subscribe = new \Fcm\Topic\Subscribe($value);
            $subscribe->addDevice($pushToken);
            $client->send($subscribe);
        }
    }
}
