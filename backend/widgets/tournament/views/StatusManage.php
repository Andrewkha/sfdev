<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/30/2018
 * Time: 12:21 PM
 */

use core\entities\sf\Tournament;
use core\helpers\TournamentHelper;

/** @var $buttons string */
/** @var $tournament Tournament */


?>

<div class="row">
    <div class="col-sm-5 col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading "><strong>Управление статусом</strong></div>
            <div class="panel-body">
                <p>
                    <span>Текущий статуc</span>
                    <?= TournamentHelper::statusLabel($tournament->status);?>
                </p>
                <?= $buttons;?>
            </div>
        </div>
    </div>
</div>