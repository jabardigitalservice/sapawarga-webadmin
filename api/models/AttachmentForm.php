<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AttachmentForm extends Model
{
    public $file;
    public $type;

    const SCENARIO_PHONE_BOOK_PHOTO_CREATE = 'phone-book-photo-create';

    public function rules()
    {
        $uploadMaxSize = Yii::$app->params['upload_max_size'];

        return [
            ['file', 'required'],
            [
                'file',
                'file',
                'skipOnEmpty' => false,
                'extensions' => 'png, jpg',
                'maxSize' => $uploadMaxSize,
                'on' => self::SCENARIO_PHONE_BOOK_PHOTO_CREATE
            ],

            ['type', 'required'],
        ];
    }
}
