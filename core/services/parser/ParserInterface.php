<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/16/2018
 * Time: 1:37 PM
 */

namespace core\services\parser;


interface ParserInterface
{
    public function parse($url);
}