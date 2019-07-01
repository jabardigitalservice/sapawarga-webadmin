<?php

namespace app\models\Attachment;

use app\models\AttachmentForm;
use Intervention\Image\ImageManager;
use Yii;

class PhoneBookPhotoForm extends AttachmentForm
{
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
