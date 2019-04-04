<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController as BaseActiveController;

class ActiveController extends BaseActiveController
{
    /**
     * @var string|array the configuration for creating the serializer that formats the response data.
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
}
