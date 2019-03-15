<?php

namespace app\rest;

use yii\rest\Serializer as BaseSerializer;

class Serializer extends BaseSerializer
{
    /**
     * Serializes the validation errors in a model.
     * @param Model $model
     * @return array the array representation of the errors
     */
    protected function serializeModelErrors($model)
    {
        $this->response->setStatusCode(422, 'Data Validation Failed.');
        $result = [];
        foreach ($model->getFirstErrors() as $name => $message) {
            $result[$name] = [$message];
        }

        return $result;
    }
}
