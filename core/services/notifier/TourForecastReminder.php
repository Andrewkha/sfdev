<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 5/18/2018
 * Time: 3:44 PM
 */

namespace core\services\notifier;


use core\entities\sf\Forecast;
use core\entities\sf\Tournament;
use core\entities\user\User;
use core\services\UsersStandings\ForecastTour;
use yii\db\ActiveQuery;
use core\entities\sf\Game;

class TourForecastReminder implements NotificationInterface
{
    private $tournament;
    private $tour;
    private $threshold;
    private $user;
    private $forecastTour;


    public function __construct(Tournament $tournament, User $user, $tour, $threshold)
    {
        $this->tournament = $tournament;
        $this->user = $user;
        $this->tour = $tour;
        $this->threshold = $threshold;
        $this->forecastTour = $this->init($user);
    }

    public function getToUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        if ($this->forecastTour->isTourForecastEmpty()) {
            return 'Напоминание: сделайте прогноз на ' . $this->tour . ' тур ' . $this->tournament->name;
        } else {
            return 'Внимание: прогноз на ' . $this->tour . ' тур ' . $this->tournament->name . ' неполный';
        }

    }

    public function getContent(): array
    {
        $user = $this->user;
        $games = $this->forecastTour;
        $data = ['tournament' => $this->tournament, 'tour' => $this->tour, 'games' => $games, 'user' => $user];

        return $data;
    }

    private function init(User $user): ForecastTour
    {
        $games = $this->tournament->getGames()->where(['tour' => $this->tour])->with(['forecasts' => function(ActiveQuery $query) use ($user) {
            $query->andWhere(['user_id' => $user->id]);
        }])->all();

        $forecastTour = new ForecastTour($this->tour);

        foreach ($games as $game) {
            /** @var Game $game */
            if ($game->forecasts) {
                /** @var Forecast $forecast */
                $forecast = $game->forecasts[0];
                $forecastTour->addGame(
                    $game->homeTeam->name,
                    $game->guestTeam->name,
                    $this->tour,
                    $game->date,
                    null,
                    null,
                    $forecast->homeFscore,
                    $forecast->guestFscore,
                    null
                );
            } else {
                $forecastTour->addGame(
                    $game->homeTeam->name,
                    $game->guestTeam->name,
                    $this->tour,
                    $game->date,
                    null,
                    null,
                    null,
                    null,
                    null
                );
            }
        }

        return $forecastTour;
    }

    public function getTemplate()
    {
        return 'notifications/forecastReminder';
    }

    public function isAllowSendNotification(): bool
    {
        $user = $this->user;
        $complete = $this->forecastTour->isTourForecastComplete();
        $count = $this->tournament->getForecastReminders()->where(['tour' => $this->tour])->andWhere(['user_id' => $user->id])->count();

        return ($count < $this->threshold) && !$complete;
    }

    public function getLoggerCategory()
    {
        return 'NotificationForecastReminder';
    }

    public function getErrorMessage()
    {
        $user = $this->user->username;
        return 'Error sending forecast reminder. Tournament ' . $this->tournament->name . ', tour ' . $this->tour . ', user ' . $user;
    }

    public function getSuccessMessage()
    {
        $username = $this->user->username;
        return 'Forecast reminder Tournament ' . $this->tournament->name . ', tour ' . $this->tour . ', user ' . $username . ' successfully sent';
    }

    public function afterAction()
    {
        $this->tournament->addForecastReminder($this->tour, $this->user->id, time());
    }
}