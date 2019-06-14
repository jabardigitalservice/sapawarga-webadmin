<?php

namespace app\models;

use yii\base\Model;
use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message as PushMessage;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Topic;
use sngrl\PhpFirebaseCloudMessaging\Notification as PushNotification;

/**
 * @property string $title
 * @property string $description
 * @property mixed $data
 * @property string $topic
 */
class Message extends Model
{
    /** @var string */
    public $title;
    /** @var string */
    public $description;
    /** @var array */
    public $data;
    /** @var string */
    public $topic;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            [['title', 'description', 'data'], 'trim'],
            ['title', 'string', 'max' => 255],
            ['topic', 'default', 'value' => 'all'], // Default value for topic, send to all users
            [['description', 'data'], 'default'],
        ];
    }

    public function fields()
    {
        $fields = [
            'title',
            'description',
            'data',
            'topic',
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

    public function send()
    {
        $server_key = getenv('FCM_KEY');
        $client = new Client();
        $client->setApiKey($server_key);
        $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());

        $notification = new PushNotification($this->title, $this->description);
        $notification->setSound('default');
        $notification->setClickAction('FCM_PLUGIN_ACTIVITY');

        $message = new PushMessage();
        $message->setPriority('high');
        $message->addRecipient(new Topic($this->topic));
        $message
            ->setNotification($notification)
            ->setData($this->data);

        $response = $client->send($message);
    }
}
