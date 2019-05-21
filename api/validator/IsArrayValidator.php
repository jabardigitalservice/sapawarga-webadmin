<?php

namespace app\validator;

use yii\validators\Validator;

class IsArrayValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if (is_array($model->$attribute) === false) {
            $this->addError($model, $attribute, 'Isian {attribute} harus berupa array.');
        }
    }
}
