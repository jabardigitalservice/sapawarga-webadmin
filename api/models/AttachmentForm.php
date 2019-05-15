<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class AttachmentForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public $type;
}
