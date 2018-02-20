<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/19/2018
 * Time: 5:17 PM
 */

namespace console\controllers;


use core\access\Rbac;
use core\entities\DataTransfer\Country;
use core\repositories\sf\CountryRepository;
use yii\console\Controller;

class DataTransferController extends Controller
{
    private $countries;
    private $manager;

    public function __construct(string $id, $module, CountryRepository $countries, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->countries = $countries;
        $this->manager = \Yii::$app->authManager;
    }

    public function actionImport()
    {

        $this->stdout('Importing countries data' . PHP_EOL);
            try {
                $this->countriesData();
            } catch (\Exception $e) {
                $this->stdout($e->getMessage() . PHP_EOL);
            }
        $this->stdout('Done!' . PHP_EOL);

        $this->stdout('Initializing RBAC config' . PHP_EOL);
        $this->rbacInit();
        $this->stdout('Done' . PHP_EOL);

    }

    private function countriesData()
    {
        $reader = new \XMLReader();

        if (!$reader->open('console/import/countries.xml')) {
            throw new \RuntimeException('Can not open the source file');
        }

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

    private function rbacInit()
    {
        $am = $this->manager;
        $am->removeAll();

        $user = $am->createRole(Rbac::ROLE_USER);
        $user->description = 'Regular site user';
        $am->add($user);

        $admin = $am->createRole(Rbac::ROLE_ADMIN);
        $admin->description = 'Site administrator';
        $am->add($admin);

        $am->addChild($admin, $user);
    }
}