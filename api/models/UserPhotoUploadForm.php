<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * User Photo Upload form
 */
class UserPhotoUploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $image;

    public function rules()
    {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    public function upload(User $user)
    {
        $bucket = \Yii::$app->fileStorage->getBucket('imageFiles');

        $relativePath = sprintf('user-%s/%s', $user->getId(), $this->image->name);

        $bucket->saveFileContent($relativePath, file_get_contents($this->image->tempName));

        return $relativePath;
    }
}
