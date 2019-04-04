<?php

namespace app\models;

use Intervention\Image\ImageManagerStatic as Image;
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
        $uploadMaxSize = Yii::$app->params['upload_max_size'];

        return [
            [['image'], 'required'],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxSize' => $uploadMaxSize],
        ];
    }

    /**
     * @param \app\models\User $user
     *
     * @return string
     */
    public function upload(User $user)
    {
        if ($image = $this->cropAndResizePhoto($this->image->tempName)) {
            $relativePath = sprintf('user-%s/%s', $user->getId(), $this->image->name);

            $bucket = \Yii::$app->fileStorage->getBucket('imageFiles');
            $bucket->saveFileContent($relativePath, $image->encode());

            return $relativePath;
        }

        return false;
    }

    /**
     * @param $filePath
     *
     * @return \Intervention\Image\Image|\Intervention\Image\ImageManagerStatic
     */
    public function cropAndResizePhoto($filePath)
    {
        return Image::make($filePath)->fit(640, 640);
    }
}
