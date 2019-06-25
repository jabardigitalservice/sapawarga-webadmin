<?php

namespace app\components;

use Yii;
use app\models\Category;

class ModelHelper
{
    /**
     * Checks if category_id is part of category_type
     *
     * @param $id
     * @param $params
     */
    public static function validateCategoryID($model, $attribute)
    {
        $request = Yii::$app->request;

        if ($request->isPost || $request->isPut) {
            $searched_category_id = Category::find()
                ->where(['id' => $model->$attribute])
                ->andWhere(['type' => $model::CATEGORY_TYPE]);

            if ($searched_category_id->count() <= 0) {
                $model->addError($attribute, Yii::t('app', 'error.id.invalid'));
            }
        }
    }

    /**
     * Checks if a new model needs to send a notification
     *
     * @param $insert
     * @param $changedAttributes
     * @param $model
     */
    public static function isSendNotification($insert, $changedAttributes, $model)
    {
        if ($insert) { // Model is created
            return $model->status == $model::STATUS_PUBLISHED;
        } else { // Model is updated
            if (array_key_exists('status', $changedAttributes)) {
                return $model->status == $model::STATUS_PUBLISHED;
            }
        }
    }
}
