<?php

namespace app\models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
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
            Survey::STATUS_PUBLISHED
        ];

        $query->andFilterWhere(['in', 'status', $filterStatusList]);

        $today = new Carbon();

        $query->andFilterWhere(['<=', 'start_date', $today->toDateString()]);
        $query->andFilterWhere(['>=', 'end_date', $today->toDateString()]);

        return $this->getQueryAll($query, $params);
    }

    protected function getQueryAll($query, $params)
    {
        $pageLimit = Arr::get($params, 'limit');
        $sortBy    = Arr::get($params, 'sort_by', 'created_at');
        $sortOrder = Arr::get($params, 'sort_order', 'descending');
        $sortOrder = $this->getSortOrder($sortOrder);

        return new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => [$sortBy => $sortOrder]],
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
}
