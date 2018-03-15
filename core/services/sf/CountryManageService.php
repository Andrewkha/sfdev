<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/19/2018
 * Time: 4:40 PM
 */

namespace core\services\sf;


use core\entities\sf\Country;
use core\forms\sf\CountryForm;
use core\repositories\sf\CountryRepository;

class CountryManageService
{
    private $countries;

    public function __construct(CountryRepository $repository)
    {
        $this->countries = $repository;
    }

    public function create(CountryForm $form): Country
    {
        $country = Country::create($form->name, $form->slug);
        $this->countries->save($country);

        return $country;
    }

    /**
     * @param $slug
     * @param CountryForm $form
     * @return Country
     * @throws \yii\web\NotFoundHttpException
     */
    public function edit($slug, CountryForm $form): Country
    {
        $country = $this->getBySlug($slug);
        $country->edit($form->name, $form->slug);
        $this->countries->save($country);

        return $country;
    }

    /**
     * @param $slug
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove($slug): void
    {
        $country = $this->getBySlug($slug);
        $this->countries->remove($country);
    }

    /**
     * @param $slug
     * @return Country
     * @throws \yii\web\NotFoundHttpException
     */
    public function getBySlug($slug): Country
    {
        return $this->countries->getBySlug($slug);
    }
}