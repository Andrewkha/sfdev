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
use core\forms\sf\TeamForm;
use core\repositories\sf\CountryRepository;
use core\repositories\sf\TeamRepository;

class CountryManageService
{
    private $countries;
    private $teams;

    public function __construct(CountryRepository $repository, TeamRepository $teams)
    {
        $this->countries = $repository;
        $this->teams = $teams;
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
        if ($this->teams->existsByCountry($country->id)) {
            throw new \DomainException('Нельзя удалить страну, если есть связанные команды');
        }
        $this->countries->remove($country);
    }

    public function addTeam($country_id, TeamForm $form): void
    {
        $country = $this->countries->get($country_id);
        $country->addTeam(
            $form->name,
            $form->slug,
            $form->logo
        );

        $this->countries->save($country);
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