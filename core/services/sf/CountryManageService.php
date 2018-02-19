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

        return $country;
    }

    public function edit($slug, CountryForm $form): void
    {
        $country = $this->getBySlug($slug);
        $country->edit($form->name, $form->slug);
        $this->countries->save($country);
    }

    public function remove($slug): void
    {
        $country = $this->getBySlug($slug);
        $this->countries->remove($country);
    }

    public function getBySlug($slug): Country
    {
        return $this->countries->getBySlug($slug);
    }
}