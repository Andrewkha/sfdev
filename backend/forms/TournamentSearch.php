<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 23.03.2018
 * Time: 13:27
 */

namespace backend\forms;


use core\entities\sf\Tournament;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TournamentSearch extends Model
{
    public $id;
    public $name;
    public $slug;
    public $type;
    public $country_id;
    public $status;
    public $startDate;

    public function rules()
    {
        return [
            [['id', 'type', 'country_id', 'status', 'startDate'], 'integer'],
            [['name', 'slug'], 'safe' ]
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Tournament::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'key' => function (Tournament $tournament) {
                return [
                    'slug' => $tournament->slug,
                ];
            },
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC]
            ]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'country_id' => $this->country_id,
            'status' => $this->status,
            'startDate' => $this->startDate,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}