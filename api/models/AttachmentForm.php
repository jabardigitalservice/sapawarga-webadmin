<?php

namespace app\models;

use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use yii\base\Model;
use yii\web\UploadedFile;
use yii2tech\filestorage\BucketInterface;

class AttachmentForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public $type;

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
