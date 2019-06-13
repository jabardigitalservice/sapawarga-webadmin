<?php

namespace app\models\Attachment;

use app\models\AttachmentForm;
use Intervention\Image\ImageManager;
use Yii;

class AspirasiPhotoForm extends AttachmentForm
{
    public function rules()
    {
        $uploadMaxSize = Yii::$app->params['upload_max_size'];

        return [
            [['file', 'type'], 'required'],
            [
                'file',
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
    protected function getRelativePath()
    {
        return 'aspirasi';
    }


    /**
     * @param $filePath
     *
     * @return \Intervention\Image\Image|\Intervention\Image\ImageManager
     */
    public function cropAndResizePhoto($filePath)
    {
        return $this->imageProcessor->make($filePath)->fit(1280, 720);
    }
}
