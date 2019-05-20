<?php

namespace app\models;

use yii\base\Model;
use Fcm\FcmClient;
use Fcm\Topic\Subscribe;
use Fcm\Push\Notification as PushNotification;

class Notification extends Model
{
    public static function subscribe($pushToken, $areaIds)
    {
        $fcm_key = getenv('FCM_KEY');
        $sender_id = getenv('FCM_SENDER_ID');
        $client = new FcmClient($fcm_key, $sender_id);

        // Subscribe $device_id to a topic
        foreach ($areaIds as $topic) {
            $subscribe = new Subscribe($topic);
            $subscribe->addDevice($pushToken);
            $client->send($subscribe);
        }
    }

    public static function send($message, $topics)
    {
        $fcm_key = getenv('FCM_KEY');
        $sender_id = getenv('FCM_SENDER_ID');

        $client = new FcmClient($fcm_key, $sender_id);
        $notification = new PushNotification();
        $notification
            ->setTitle($message['title'])
            ->setBody($message['description'])
            ->addTopic($topics);

        $response_fcm = $client->send($notification);
    }
}
