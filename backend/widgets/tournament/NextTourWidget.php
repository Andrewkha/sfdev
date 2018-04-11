<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/11/2018
 * Time: 11:19 AM
 */

namespace backend\widgets\tournament;

use core\entities\sf\Tournament;
use core\repositories\sf\TournamentRepository;
use yii\base\Widget;

/**
 * Class NextTourWidget
 * @package backend\widgets\tournament
 *
 * @property Tournament $tournament
 */

class NextTourWidget extends Widget
{
    public $tournament;

    private $repository;

    public function __construct(TournamentRepository $repository, array $config = [])
    {
        parent::__construct($config);
        $this->repository = $repository;
    }

    public function run()
    {
        $nextTour = $this->repository->getNextTour($this->tournament);
        return $this->render('nextTour', ['tour' => $nextTour, 'tournament' => $this->tournament]);
    }
}