<?php

namespace app\validator;

use yii\validators\Validator;

class InputCleanValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if ($model->$attribute !== strip_tags($model->$attribute)) {
            $this->addError($model, $attribute, 'Isian {attribute} mengandung karakter yang tidak diperbolehkan.');
        }
    }
}
