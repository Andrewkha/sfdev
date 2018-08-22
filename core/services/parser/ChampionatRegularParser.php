<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/16/2018
 * Time: 1:37 PM
 */

namespace core\services\parser;


use DiDom\Document;

class ChampionatRegularParser implements ParserInterface
{

    public function parse($url)
    {
        //$html = new Document($url, true);
        $html = new Document('pl.htm', true);

        $table = $html->find('table.table.b-table-sortlist tbody')[0];

        $return = [];

        foreach ($table->find('tr') as $row) {
            $time = $this->autoTimeToUnix($row->find('td.sport__calendar__table__date')[0]->text());
            $home = $row->find('td.sport__calendar__table__teams a.sport__calendar__table__team')[0]->text();
            $guest = $row->find('td.sport__calendar__table__teams a.sport__calendar__table__team')[1]->text();
            $tour = $row->find('td.sport__calendar__table__tour')[0]->text();
            $scoreHome = $this->calculateHomeScore($row->find('td.sport__calendar__table__result span.sport__calendar__table__result__left')[0]->text());
            $scoreGuest = $this->calculateGuestScore($row->find('td.sport__calendar__table__result span.sport__calendar__table__result__right')[0]->text());

            $return[] = new ParsingGameItem($time, $tour, $home, $guest, $scoreHome, $scoreGuest);
        }

        return $return;
    }

    private function calculateHomeScore($score)
    {
        return (trim($score) === '-')? NULL : (int)trim($score);
    }

    private function calculateGuestScore($score)
    {
        return (trim($score) === '-')? NULL : (int)trim($score);
    }

    private function autoTimeToUnix($str)
    {
        $str = trim($str);

        $day = (int)substr($str, 0, 2);
        $str = trim(substr($str, 3));

        $month = (int)substr($str, 0, 2);
        $str = trim(substr($str, 3));

        $year = (int)substr($str, 0, 4);

        $str = trim(substr($str, 5));
        $hour = (int)substr($str, 0, 2);

        $str = trim(substr($str, 3));
        $min = (int)substr($str, 0, 2);

        return mktime($hour, $min , 0, $month, $day, $year);
    }

}