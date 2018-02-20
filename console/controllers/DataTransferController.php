<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/19/2018
 * Time: 5:17 PM
 */

namespace console\controllers;


use core\entities\DataTransfer\Country;
use core\repositories\sf\CountryRepository;
use yii\console\Controller;

class DataTransferController extends Controller
{
    private $countries;

    public function __construct(string $id, $module, CountryRepository $countries, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->countries = $countries;
    }

    public function actionImport()
    {
        $this->countriesData();
    }

    private function countriesData()
    {
        $reader = new \XMLReader();
        $reader->open('console/import/countries.xml');

        $country = [];

        while ($reader->read()) {
            if($reader->nodeType == \XMLReader::ELEMENT) {
                if ($reader->localName == 'country') {
                    $country[] = Country::create($reader->getAttribute('name'), '');
                }
            }
        }

        $reader->close();

        foreach ($country as $one) {
            $this->countries->save($one);
        }
    }
}