<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends Model
{
    public $q;
    public $page = 1;
    public $per_page = 20;
    public $range_roles = [];
    public $not_in_status = [];

    public $kabkota_id;
    public $kec_id;
    public $kel_id;
    public $rw;

    public function rules()
    {
        return [
            [['page', 'per_page'], 'integer'],
            [['q'], 'string', 'max' => 50],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function getDataProvider()
    {
        $queryParams = [];
        $query = User::find()
            ->where(['not in', 'user.status', $this->not_in_status])
            ->andWhere(['between', 'user.role', $this->range_roles[0], $this->range_roles[1]]);

        // Limit search based on user role's authorized area
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

        if ($this->q) {
            $query->andWhere([
                'or',
                ['like', 'user.username', $this->q],
                ['like', 'user.email', $this->q],
                ['like', 'user.registration_ip', $this->q],
                ['like', 'user.last_login_ip', $this->q],
            ]);
            $queryParams['q'] = $this->q;
        }

        $page = $this->page > 0 ? ($this->page - 1) : 0;
        $pageSize = (int)$this->per_page;

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'forcePageParam' => true,
                'page' => $page,
                'pageParam' => 'page',
                'defaultPageSize' => $pageSize,
                'pageSizeLimit' => [10, 50, 100],
                'pageSizeParam' => 'per_page',
                'validatePage' => true,
                'params' => $queryParams,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
        ]);

        $rows = $provider->getModels();
        $pagination = array_intersect_key(
            (array)$provider->pagination,
            array_flip(
                \Yii::$app->params['paginationParams']
            )
        );

        $pagination['firstRowNo'] = $pagination['totalCount'] - ($page * $pageSize);

        return [
            'rows' => $rows,
            'pagination' => $pagination,
        ];
    }
}
