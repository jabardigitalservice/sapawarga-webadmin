<?php

namespace app\models\Attachment;

use app\models\AttachmentForm;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Yii;
use yii2tech\filestorage\BucketInterface;

class PhoneBookPhotoForm extends AttachmentForm
{
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
            ['file', 'required'],
            [
                'file',
                'file',
                'skipOnEmpty' => false,
                'extensions'  => 'png, jpg',
                'maxSize'     => $uploadMaxSize,
            ],
        ];
    }

    /**
     * @return bool
     */
    public function upload()
    {
        /**
         * @var \yii2tech\filestorage\BucketInterface $bucket
         */
        $bucket = Yii::$app->fileStorage->getBucket('imageFiles');
        $imageProcessor = new ImageManager();

        $this->setBucket($bucket);
        $this->setImageProcessor($imageProcessor);

        $tempFilePath = $this->file->tempName;

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
        return 'general';
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

    /**
     * @return string
     */
    public function getFileUrl()
    {
        return $this->bucket->getFileUrl($this->getRelativeFilePath());
    }
}
