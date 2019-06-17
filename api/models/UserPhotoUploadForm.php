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

    /**
     * @var BucketInterface
     */
    protected $bucket;

    /**
     * @var string
     */
    protected $relativeFilePath;

    public function rules()
    {
        $uploadMaxSize = Yii::$app->params['upload_max_size'];

        return [
            [['image'], 'required'],

            [
                'image',
                'file',
                'skipOnEmpty' => false,
                'mimeTypes'   => 'image/jpeg, image/jpg, image/png',
                'maxSize'     => $uploadMaxSize,
            ],
        ];
    }

    /**
     * @return bool
     */
    public function upload()
    {
        $tempFilePath = $this->image->tempName;

        return $this->save($tempFilePath);
    }

    /**
     * @param string $tempFilePath
     * @return bool
     */
    public function save($tempFilePath)
    {
        if ($image = $this->cropAndResizePhoto($tempFilePath)) {
            $this->relativeFilePath = $this->createFilePath();

            return $this->bucket->saveFileContent($this->relativeFilePath, $image->encode());
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
        $extension    = 'jpg';

        return sprintf('%s/%s.%s', $relativePath, $filename, $extension);
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

    /**
     * @param BucketInterface $bucket
     */
    public function setBucket(BucketInterface $bucket)
    {
        $this->bucket = $bucket;
    }

    /**
     * @return void
     */
    public function setRelativePath($path)
    {
        $this->relativeFilePath = $path;
    }

    /**
     * @return string
     */
    public function getRelativeFilePath()
    {
        return $this->relativeFilePath;
    }
}
