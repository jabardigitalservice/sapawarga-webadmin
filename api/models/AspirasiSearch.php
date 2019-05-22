<?php

namespace app\models;

use Illuminate\Support\Arr;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AspirasiSearch represents the model behind the search form of `app\models\Aspirasi`.
 */
class AspirasiSearch extends Aspirasi
{
    /**
     * @var \app\models\User
     */
    public $user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Aspirasi::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['author_id' => $this->author_id]);

        $query->andFilterWhere(['<>', 'status', Aspirasi::STATUS_DELETED]);

        if ($this->user->role === User::ROLE_ADMIN) {
            $query->andFilterWhere(['<>', 'status', Aspirasi::STATUS_DRAFT]);
        }

        if (Arr::has($params, 'title')) {
            $query->andWhere(['like', 'title', Arr::get($params, 'title')]);
        }

        if (Arr::has($params, 'description')) {
            $query->andWhere(['like', 'description', Arr::get($params, 'description')]);
        }

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
