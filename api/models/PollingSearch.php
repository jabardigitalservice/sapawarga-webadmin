<?php

namespace app\models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\Types\Array_;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PollingSearch represents the model behind the search form of `app\models\Polling`.
 */
class PollingSearch extends Polling
{
    const SCENARIO_LIST_USER = 'list-user';

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Polling::find()->with('category', 'kelurahan', 'kecamatan', 'kabkota', 'answers');

        // grid filtering conditions
        $query->andFilterWhere(['id' => $this->id]);

        $query->andFilterWhere(['<>', 'status', Polling::STATUS_DELETED]);

        if ($this->scenario === self::SCENARIO_LIST_USER) {
            return $this->getQueryListUser($query, $params);
        }

        return $this->getQueryAll($query, $params);
    }

    protected function getQueryListUser($query, $params)
    {
        $filterStatusList = [
            Survey::STATUS_PUBLISHED,
        ];

        $query->andFilterWhere(['in', 'status', $filterStatusList]);

        $today = new Carbon();

        $query->andFilterWhere(['<=', 'start_date', $today->toDateString()]);
        $query->andFilterWhere(['>=', 'end_date', $today->toDateString()]);

        $this->filterByUserArea($query, $params);

        return $this->getQueryAll($query, $params);
    }

    protected function getQueryAll($query, $params)
    {
        $pageLimit = Arr::get($params, 'limit');
        $sortBy    = Arr::get($params, 'sort_by', 'created_at');
        $sortOrder = Arr::get($params, 'sort_order', 'descending');
        $sortOrder = $this->getSortOrder($sortOrder);

        return new ActiveDataProvider([
            'query'      => $query,
            'sort'       => ['defaultOrder' => [$sortBy => $sortOrder]],
            'pagination' => [
                'pageSize' => $pageLimit,
            ],
        ]);
    }

    protected function getSortOrder($sortOrder)
    {
        switch ($sortOrder) {
            case 'descending':
                return SORT_DESC;
                break;
            case 'ascending':
            default:
                return SORT_ASC;
                break;
        }
    }

    protected function filterByUserArea(&$query, $params)
    {
        $kabKotaId = Arr::get($params, 'kabkota_id');
        $kecId     = Arr::get($params, 'kec_id');
        $kelId     = Arr::get($params, 'kel_id');
        $rw        = Arr::get($params, 'rw');

        $query->andWhere('
            (kabkota_id = :kabkota_id AND kec_id IS NULL AND kel_id IS NULL AND rw IS NULL) OR 
            (kabkota_id = :kabkota_id AND kec_id = :kec_id AND kel_id IS NULL AND rw IS NULL) OR 
            (kabkota_id = :kabkota_id AND kec_id = :kec_id AND kel_id = :kel_id AND rw IS NULL) OR
            (kabkota_id = :kabkota_id AND kec_id = :kec_id AND kel_id = :kel_id AND rw = :rw)', [

            ':kabkota_id' => $kabKotaId,
            ':kec_id'     => $kecId,
            ':kel_id'     => $kelId,
            ':rw'         => $rw,
        ]);

        return $query;
    }
}
