<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

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
        $query = PhoneBook::find();

        // add conditions that should always apply here

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

        $isCustomFilter = isset($params['kabkota_id']);

        if ($isCustomFilter === false && $user->role === User::ROLE_USER) {
            $query->andFilterWhere(['kabkota_id' => $user->kabkota_id]);
        }

        if ($isCustomFilter) {
            $query->andFilterWhere(['kabkota_id' => $params['kabkota_id'] ?? null]);
            $query->andFilterWhere(['kec_id' => $params['kec_id'] ?? null]);
            $query->andFilterWhere(['kel_id' => $params['kel_id'] ?? null]);
        }

        return $dataProvider;
    }
}
