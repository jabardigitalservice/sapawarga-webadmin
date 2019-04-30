<?php

namespace app\models;

use Illuminate\Support\Arr;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;;

/**
 * PhoneBookSearch represents the model behind the search form of `app\models\PhoneBook`.
 */
class PhoneBookSearch extends PhoneBook
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
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
    public function search(User $user, $params)
    {
        $lat = Arr::get($params, 'lat');
        $lon = Arr::get($params, 'lon');
        if ($lat && $lon) {
            return $this->searchNearby($user, $params);
        }

        $query = PhoneBook::find();

        $sortBy    = Arr::get($params, 'sort_by', 'seq');
        $sortOrder = Arr::get($params, 'sort_order', 'ascending');
        $sortOrder = $this->getSortOrder($sortOrder);

        $pageLimit = Arr::get($params, 'limit');

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

        $query->andFilterWhere(['<>', 'status', PhoneBook::STATUS_DELETED]);

        $query->andFilterWhere(['like', 'name', $params['search'] ?? null]);

        // Jika User
        if ($user->role === User::ROLE_USER) {
            return $this->getQueryRoleUser($user, $query, $params);
        }

        // Else Has Admin Role, tampilkan semua
        return $this->getQueryAll($query, $params);
    }

    /**
     * Search using SqlDataProvider
     *
     * @param array $params
     *
     * @return SqlDataProvider
     */
    public function searchNearby(User $user, $params)
    {
        $sql = file_get_contents(__DIR__ . '/scripts/getNearestByRadius.sql');
        $provider = new SqlDataProvider([
            'sql' => $sql,
        ]);

        return $provider;
    }

    protected function getQueryRoleUser($user, $query, $params)
    {
        // Jika memilih custom filter, akan override semua parameter default
        if ($this->isCustomFilter($params) === true) {
            $this->filterByArea($query, $params);
        } else {
            // Jika tidak memilih custom filter,
            // by default tampilkan daftar instansi di Kab/Kota dimana user tersebut tinggal
            $params['kabkota_id'] = Arr::get($user, 'kabkota_id');

            $this->filterByArea($query, $params);
        }

        $query->orWhere(['and',
            ['kabkota_id' => null],
            ['kec_id' => null],
            ['kel_id' => null],
        ]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['seq' => SORT_DESC]],
        ]);
    }

    protected function getQueryAll($query, $params)
    {
        $this->filterByArea($query, $params);

        return new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['seq' => SORT_DESC]],
            'pagination' => [
                'pageSize' => Arr::get($params, 'limit'),
            ],
        ]);
    }

    protected function isCustomFilter($params)
    {
        return Arr::has($params, 'kabkota_id') || Arr::has($params, 'kec_id') || Arr::has($params, 'kel_id');
    }

    protected function filterByArea(&$query, $params)
    {
        if (Arr::has($params, 'kabkota_id')) {
            $query->andFilterWhere(['kabkota_id' => $params['kabkota_id']]);
        }

        if (Arr::has($params, 'kec_id')) {
            $query->andFilterWhere(['kec_id' => $params['kec_id']]);
        }

        if (Arr::has($params, 'kel_id')) {
            $query->andFilterWhere(['kel_id' => $params['kel_id']]);
        }

        return $query;
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
