<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/20/2018
 * Time: 12:31 PM
 */

namespace core\entities;


interface AggregateRoot
{
    public function releaseEvents(): array;
}