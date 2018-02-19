<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/19/2018
 * Time: 4:14 PM
 */

namespace core\repositories\sf;


use core\entities\sf\Country;
use yii\web\NotFoundHttpException;

class CountryRepository
{
    /**
     * @param $id
     * @return Country
     * @throws NotFoundHttpException
     */
    public function get($id): Country
    {
        if (!$country = Country::findOne($id)) {
            throw new NotFoundHttpException('Страна не найдена' );
        }

        return $country;
    }

    public function getBySlug($slug): Country
    {
        /* @var $country Country */
        if (!$country = Country::find()->andWhere(['slug' => $slug])->one()) {
            throw new NotFoundHttpException('Страна не найдена' );
        }

        return $country;
    }

    public function save(Country $country): void
    {
        if (!$country->save()) {
            throw new \RuntimeException('Ошибка сохранения');
        }
    }

    /**
     * @param Country $country
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Country $country): void
    {
        if (!$country->delete()) {
            throw new \RuntimeException();
        }
    }
}