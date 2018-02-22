<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/22/2018
 * Time: 1:52 PM
 */

namespace core\dispatchers;


interface EventDispatcher
{
    public function dispatch($event): void;
    public function dispatchAll(array $events): void;
}