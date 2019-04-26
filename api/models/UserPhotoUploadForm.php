<?php

namespace app\models;

use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii2tech\filestorage\BucketInterface;

/**
 * User Photo Upload form
 */
class UserPhotoUploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $image;

    /**
     * @var ImageManager
     */
    protected $imageProcessor;

    public function rules()
    {
        $uploadMaxSize = Yii::$app->params['upload_max_size'];

        return [
            [['image'], 'required'],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxSize' => $uploadMaxSize],
        ];
    }

    /**
     * @param string $tempFilePath
     * @param \yii2tech\filestorage\BucketInterface $bucket
     * @return bool
     */
    public function upload($tempFilePath, BucketInterface $bucket)
    {
        if ($image = $this->cropAndResizePhoto($tempFilePath)) {
            $relativeFilePath = $this->createFilePath();

            return $bucket->saveFileContent($relativeFilePath, $image->encode());
        }

        return false;
    }

    /**
     * @return string
     */
    protected function createRandomFilename()
    {
        return Str::random(32);
    }

    /**
     * @return string
     */
    protected function getRelativePath()
    {
        return 'avatars';
    }

    /**
     * @return string
     */
    public function createFilePath()
    {
        $relativePath = $this->getRelativePath();
        $filename     = $this->createRandomFilename();

        return sprintf('%s/%s', $relativePath, $filename);
    }

    /**
     * @param $filePath
     *
     * @return \Intervention\Image\Image|\Intervention\Image\ImageManager
     */
    public function cropAndResizePhoto($filePath)
    {
        return $this->imageProcessor->make($filePath)->fit(640, 640);
    }

    /**
     * @param \app\models\User $user
     * @param $relativePath
     * @return string
     */
    public function setUserProfilePhoto($user, $relativePath)
    {
        $user->photo_url = $relativePath;
        $user->save(false);

        return $relativePath;
    }

    /**
     * @param $imageProcessor
     */
    public function setImageProcessor($imageProcessor)
    {
        $this->imageProcessor = $imageProcessor;
    }
}
