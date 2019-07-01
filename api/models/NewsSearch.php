<?php

namespace app\models;

use Illuminate\Support\Arr;
use yii\data\ActiveDataProvider;

/**
 * NewsSearch represents the model behind the search form of `app\models\News`.
 */
class NewsSearch extends News
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
        $query = News::find()->with('channel');

        // grid filtering conditions
        $query->andFilterWhere(['id' => $this->id]);

        $filterChannelId = Arr::get($params, 'channel_id');
        $searchKeyword   = Arr::get($params, 'search');

        $query->andFilterWhere(['channel_id' => $filterChannelId]);

        $query->andFilterWhere(['like', 'title', $searchKeyword]);
        $query->orFilterWhere(['like', 'content', $searchKeyword]);

        $query->andFilterWhere(['<>', 'status', News::STATUS_DELETED]);

        if ($this->scenario === self::SCENARIO_LIST_USER) {
            return $this->getQueryListUser($query, $params);
        }

        return $this->getQueryAll($query, $params);
    }

    public function featuredList($params)
    {
        $query = News::find()->with('channel');

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['featured' => true]);
        $query->andFilterWhere(['status' => News::STATUS_ACTIVE]);

        $params['sort_by']    = 'seq';
        $params['sort_order'] = 'ascending';

        return $this->getQueryAll($query, $params);
    }

    protected function getQueryListUser($query, $params)
    {
        $filterStatusList = [
            News::STATUS_ACTIVE,
        ];

        $query->andFilterWhere(['in', 'status', $filterStatusList]);

        return $this->getQueryAll($query, $params);
    }

    protected function getQueryAll($query, $params)
    {
        $pageLimit = Arr::get($params, 'limit');
        $sortBy    = Arr::get($params, 'sort_by', 'source_date');
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
}
