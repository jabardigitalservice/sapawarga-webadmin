<?php

namespace app\models;

use Illuminate\Support\Arr;
use yii\data\SqlDataProvider;

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
     * @return SqlDataProvider
     */

    public function getStatistics($params)
    {
        $sql = 'SELECT news_channels.id, news_channels.name as title, COALESCE(stat.news_count, 0) as count
                FROM news_channels
                LEFT JOIN (
                    SELECT news.channel_id, COUNT(news.channel_id) as news_count
                    FROM news
                    WHERE news.status <> :status_deleted
                    GROUP BY news.channel_id
                ) as stat
                ON news_channels.id = stat.channel_id';

        $sortBy    = Arr::get($params, 'sort_by', 'title');
        $sortOrder = Arr::get($params, 'sort_order', 'ascending');
        $sortOrder = $this->getSortOrder($sortOrder);

        return new SqlDataProvider([
            'sql'      => $sql,
            'params'   => [':status_deleted' => News::STATUS_DELETED],
            'sort'     => [
                'defaultOrder'  => [$sortBy => $sortOrder],
                'attributes'    => [
                    'id',
                    'title',
                    'name',
                    'count',
                ],
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
