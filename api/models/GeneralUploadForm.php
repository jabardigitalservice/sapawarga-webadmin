<?php

namespace app\models;

use Yii;
use yii\base\Model;

class GeneralUploadForm extends Model
{
    public $file;
    public $type;

    public function rules()
    {
        $uploadMaxSize = Yii::$app->params['upload_max_size'];

        return [
            ['file', 'required'],
            ['file', 'file', 'skipOnEmpty' => false, 'maxSize' => $uploadMaxSize],

            ['type', 'required'],
        ];
    }
}
