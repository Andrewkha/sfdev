<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/16/2018
 * Time: 1:38 PM
 */

namespace core\services\parser;

use core\entities\sf\Game;
use core\entities\sf\Tournament;
use yii\helpers\ArrayHelper;

/**
 * Class Parser
 * @package core\services\parser
 *
 * @property ParserInterface $parser
 */

class Parser
{
    private $parser;
    private $tournament;

    public function __construct(Tournament $tournament)
    {
        $this->tournament = $tournament;
        $this->parser = $this->getParser($tournament);
    }

    private function getParser(Tournament $tournament): ParserInterface
    {
        return new ChampionatRegularParser();
    }

    private function parse()
    {
        return $this->parser->parse($this->tournament->autoprocessUrl);
    }

    public function load(): array
    {
        /** @var ParsingGameItem[] $webGames */
        $webGames = $this->parse();
        $dbGames = $this->tournament->games;
        $aliases = ArrayHelper::getColumn(ArrayHelper::index($this->tournament->teamAssignments, 'team_id'), 'alias');

        $this->validateAliases($webGames, $aliases);

        $games = [];

        foreach ($webGames as $webGame) {
            $item = array_filter($dbGames, function (Game $game) use ($webGame, $aliases) {
                return ($game->tour == $webGame->tour && $game->home_team_id == array_search($webGame->home, $aliases) && $game->guest_team_id == array_search($webGame->guest, $aliases));
            });
            if (!empty($item)) {

                /** @var Game $game */
                $game = array_shift($item);
                $game->date = $webGame->date;
                $game->homeScore = $webGame->homeScore;
                $game->guestScore = $webGame->guestScore;
                $game->tour = $webGame->tour;
                $games[] = $game;
            } else {
                $game = Game::create($webGame->tour,
                    array_search($webGame->home, $aliases),
                    array_search($webGame->guest, $aliases),
                    $webGame->date,
                    $webGame->homeScore,
                    $webGame->guestScore);
                $games[] = $game;
            }
        }

        return $games;
    }

    private function validateAliases($webGames, $aliases): bool
    {
        $webAliases = array_unique(ArrayHelper::merge(ArrayHelper::getColumn($webGames, 'home'), ArrayHelper::getColumn($webGames, 'guest')));

        foreach ($webAliases as $webAlias) {
            if (!array_search($webAlias, $aliases)) {
                throw new \DomainException('Псевдоним ' . $webAlias . ' некорректен');
            }
        }

        return true;
    }
}