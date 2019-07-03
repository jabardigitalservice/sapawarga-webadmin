<?php

namespace app\models\Attachment;

use app\models\AttachmentForm;

class NewsPhotoForm extends AttachmentForm
{
    /**
     * @return string
     */
    protected function getRelativePath()
    {
        return 'news';
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
