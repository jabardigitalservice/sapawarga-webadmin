<?php

namespace Jdsteam\Sapawarga\Behaviors;

use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;

class AreaBehavior extends Behavior
{
    public $withRw = true;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsertOrUpdate',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeInsertOrUpdate',
        ];
    }

    public function beforeInsertOrUpdate(Event $event)
    {
        $model = $this->owner;

        if ($model->kabkota_id === null) {
            return $this->resetKabupatenDown($model);
        }

        if ($model->kec_id === null) {
            return $this->resetKecamatanDown($model);
        }

        if ($model->kel_id === null) {
            return $this->resetKelurahanDown($model);
        }
    }

    protected function resetKabupatenDown($model)
    {
        $model->kec_id = null;
        $model->kel_id = null;

        if ($this->withRw) {
            $model->rw = null;
        }

        return $model;
    }

    protected function resetKecamatanDown($model)
    {
        $model->kel_id = null;

        if ($this->withRw) {
            $model->rw = null;
        }

        return $model;
    }

    protected function resetKelurahanDown($model)
    {
        if ($this->withRw) {
            $model->rw = null;
        }

        return $model;
    }
}
