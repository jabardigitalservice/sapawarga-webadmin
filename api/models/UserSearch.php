<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends Model
{
    public $search;
    public $range_roles = [];
    public $not_in_status = [];

    public $role_id;
    public $kabkota_id;
    public $kec_id;
    public $kel_id;
    public $rw;

    public function rules()
    {
        return [
            [['search'], 'string', 'max' => 50],
            [['role_id', 'kabkota_id', 'kec_id', 'kel_id', 'rw'], 'string'],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function getDataProvider()
    {
        $query = User::find()
            ->where(['not in', 'user.status', $this->not_in_status])
            ->andWhere(['between', 'user.role', $this->range_roles[0], $this->range_roles[1]]);

        // Filter by role
        if ($this->role_id) {
            $query->andWhere(['role' => User::ROLE_MAP[$this->role_id]]);
        }

        // Filter by area id
        if ($this->kabkota_id) {
            $query->andWhere(['kabkota_id' => $this->kabkota_id]);
        }
        if ($this->kec_id) {
            $query->andWhere(['kec_id' => $this->kec_id]);
        }
        if ($this->kel_id) {
            $query->andWhere(['kel_id' => $this->kel_id]);
        }
        if ($this->rw) {
            $query->andWhere(['rw' => $this->rw]);
        }

        if ($this->search) {
            $query->andWhere([
                'or',
                ['like', 'user.name', $this->search],
                ['like', 'user.phone', $this->search],
            ]);
        }

        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $provider;
    }
}
