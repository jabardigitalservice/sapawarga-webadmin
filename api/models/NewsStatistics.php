<?php

namespace app\models;

use Illuminate\Support\Arr;
use yii\data\ActiveDataProvider;

/**
 * NewsSearch represents the model behind the search form of `app\models\News`.
 */
class NewsStatistics extends News
{
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */

    public function getStatistics($params)
    {
        // \yii\helpers\VarDumper::dump('asddada');
        $query = NewsChannel::find()->with('news.channel_id');
        $query->andFilterWhere(['status' => NewsChannel::STATUS_ACTIVE]);

        $sortBy    = Arr::get($params, 'sort_by', 'name');
        $sortOrder = Arr::get($params, 'sort_order', 'ascending');
        $sortOrder = $this->getSortOrder($sortOrder);

        return new ActiveDataProvider([
            'query'      => $query,
            'sort'       => ['defaultOrder' => [$sortBy => $sortOrder]],
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
