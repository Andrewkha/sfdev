<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/19/2018
 * Time: 5:17 PM
 */

namespace console\controllers;


use core\access\Rbac;
use core\entities\sf\Country;
use core\entities\sf\Team;
use Zelenin\yii\behaviors\Slug;
use core\entities\user\User;
use core\entities\user\UserData;
use core\repositories\sf\CountryRepository;
use core\services\RoleManager;
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

        \Yii::$app->db->createCommand("SET foreign_key_checks = 0")->execute();

        /** Import Countries */
        $this->stdout('Importing countries data' . PHP_EOL);
            try {
                $this->countriesData();
            } catch (\Exception $e) {
                $this->stdout($e->getMessage() . PHP_EOL);
            }
        $this->stdout('Done!' . PHP_EOL);

        /** Initialize RBAC */
        $this->stdout('Initializing RBAC config' . PHP_EOL);
        $this->rbacInit();
        $this->stdout('Done' . PHP_EOL);

        /** Import users */
        $this->stdout('Importing users data' . PHP_EOL);
        try {
            $this->usersData();
        } catch (\Exception $e) {
            $this->stdout($e->getMessage() . PHP_EOL);
        }
        $this->stdout('Done!' . PHP_EOL);

        /** Import teams */
        $this->stdout('Importing teams data' . PHP_EOL);
        try {
            $this->teamsData();
        } catch (\Exception $e) {
            $this->stdout($e->getMessage() . PHP_EOL);
        }
        $this->stdout('Done!' . PHP_EOL);

    }

    public function actionImportTeams()
    {
        /** Import teams */
        $this->stdout('Importing teams data' . PHP_EOL);
        try {
            $this->teamsData();
        } catch (\Exception $e) {
            $this->stdout($e->getMessage() . PHP_EOL);
        }
        $this->stdout('Done!' . PHP_EOL);
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
                    $newCountry = new Country();
                    $newCountry->id = $reader->getAttribute('id');
                    $newCountry->name = $reader->getAttribute('name');
                    $country[] = $newCountry;
                }
            }
        }

        $reader->close();

        Country::deleteAll();
        foreach ($country as $one) {
            /**
             * @var $one Country
             */
            $one->attachBehavior(
                'slug', [
                    'class' => Slug::class,
                    'slugAttribute' => 'slug',
                    'attribute' => 'name',
                    // optional params
                    'ensureUnique' => true,
                    'replacement' => '-',
                    'lowercase' => true,
                    'immutable' => false,
                    // If intl extension is enabled, see http://userguide.icu-project.org/transforms/general.
                    'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
                ]
            );
            $this->countries->save($one);
        }
    }

    private function usersData()
    {
        $reader = new \XMLReader();

        if (!$reader->open('console/import/users.xml')) {
            throw new \RuntimeException('Can not open the source file');
        }

        $users = [];
        $path = 'static/origin/users/';
        $sourcePath = 'console/import/users_avatars/';


        while ($reader->read()) {
            if($reader->nodeType == \XMLReader::ELEMENT) {
                if ($reader->localName == 'user') {
                    $newUser = new User();
                    $newUser->id = $reader->getAttribute('id');
                    $newUser->userData = new UserData(
                        $newUser->username = $reader->getAttribute('username'),
                        $newUser->email = $reader->getAttribute('email'),
                        $newUser->first_name = $reader->getAttribute('first_name'),
                        $newUser->last_name = $reader->getAttribute('last_name')
                    );

                    $newUser->password_hash = $reader->getAttribute('password');

                    $newUser->auth_key = $reader->getAttribute('auth_key');
                    $newUser->status = $reader->getAttribute('active');
                    $newUser->notification = $reader->getAttribute('notifications');
                    //$newUser->avatar = $reader->getAttribute('avatar');
                    $newUser->avatar = ($reader->getAttribute('avatar') == 'default.jpg') ? '' : $newUser->id . stristr($reader->getAttribute('avatar'), '.');

                    if (file_exists($sourcePath . $reader->getAttribute('avatar')) && $reader->getAttribute('avatar') != 'default.jpg') {
                        $folder = $path . 'avatars/';

                        if (!file_exists($folder)) {
                            mkdir($folder, 0777, true);
                        }

                        if (rename($sourcePath . $reader->getAttribute('avatar'), $folder . $newUser->id . stristr($reader->getAttribute('avatar'), '.'))) {
                            $this->stdout('Renamed' . PHP_EOL);
                        }
                    }
                    $newUser->created_at = $reader->getAttribute('created_on');
                    $newUser->updated_at = $reader->getAttribute('updated_on');
                    $newUser->last_login = $reader->getAttribute('last_login');

                    $users[] = $newUser;
                }
            }
        }

        $reader->close();

        User::deleteAll();
        $roleManager = new RoleManager($this->manager);

        foreach ($users as $one) {
            /** @var $one User */
            $one->detachBehaviors();
            $one->save();
            if ($one->username == 'administrator') {
                $roleManager->assign($one->id, Rbac::ROLE_ADMIN);
            } else {
                $roleManager->assign($one->id, Rbac::ROLE_USER);
            }
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

    private function teamsData()
    {
        $reader = new \XMLReader();

        if (!$reader->open('console/import/teams.xml')) {
            throw new \RuntimeException('Can not open the source file');
        }

        $teams = [];
        $sourcePath = 'console/import/teams_logos/';
        $path = 'static/origin/teams/logo/';

        while ($reader->read()) {
            if($reader->nodeType == \XMLReader::ELEMENT) {
                if ($reader->localName == 'team') {
                    $newTeam = new Team();
                    $newTeam->id = $reader->getAttribute('id');
                    $newTeam->name = $reader->getAttribute('name');
                    $newTeam->country_id = $reader->getAttribute('country_id');
                    $newTeam->logo = $newTeam->id . '_' . $reader->getAttribute('logo');

                    if (file_exists($sourcePath . $reader->getAttribute('logo'))) {
                        $folder = $path . $newTeam->country_id . '/';

                        if (!file_exists($folder)) {
                            mkdir($folder, 0777, true);
                        }
                        if (rename($sourcePath . $reader->getAttribute('logo'), $folder . $newTeam->id . '_' . $reader->getAttribute('logo'))) {
                            $this->stdout('Renamed' . PHP_EOL);
                        }
                    }

                    $teams[] = $newTeam;
                }
            }
        }

        $reader->close();

        Team::deleteAll();

        foreach ($teams as $one) {
            /** @var $one Team */
            $one->save();
        }
    }
}