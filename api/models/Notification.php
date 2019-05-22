<?php

namespace app\models;

use yii\base\Model;
use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Topic;
use sngrl\PhpFirebaseCloudMessaging\Notification as PushNotification;

/**
 * @property string $title
 * @property string $description
 * @property mixed $data
 */
class Notification extends Model
{
    /** @var string */
    public $title;
    /** @var string */
    public $description;
    /** @var array */
    public $data;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            [['title', 'description', 'data'], 'trim'],
            ['title', 'string', 'max' => 255],
            [['description', 'data'], 'default'],
        ];
    }

    public function fields()
    {
        $fields = [
            'title',
            'description',
            'data'
        ];
        return $fields;
    }

    // Static functions
    public static function subscribe($pushToken, $areaIds)
    {
        $server_key = getenv('FCM_KEY');
        $client = new Client();
        $client->setApiKey($server_key);
        $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());

        foreach ($areaIds as $topic) {
            $response = $client->addTopicSubscription($topic, [$pushToken]);
        }
    }

    public static function unsubscribe($pushToken, $areaIds)
    {
        $server_key = getenv('FCM_KEY');
        $client = new Client();
        $client->setApiKey($server_key);
        $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());

        foreach ($areaIds as $topic) {
            $response = $client->removeTopicSubscription($topic, [$pushToken]);
        }
    }

    public static function send($msg, $topics)
    {
        $server_key = getenv('FCM_KEY');
        $client = new Client();
        $client->setApiKey($server_key);
        $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());

        $notification = new PushNotification($msg['title'], $msg['description']);
        $notification->setClickAction('FCM_PLUGIN_ACTIVITY');

        $message = new Message();
        $message->setPriority('high');
        $message->addRecipient(new Topic($topics));
        $message
            ->setNotification($notification)
            ->setData($msg['data']);

        $response = $client->send($message);
    }
}
