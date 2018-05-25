<?php

use core\services\TeamStandings\GameItem;
use core\services\TeamStandings\StandingsItem;
use yii\helpers\Html;use yii\web\View;
use yii\bootstrap\Modal;
use yii\bootstrap\Button;

/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/6/2018
 * Time: 2:15 PM
 */

/* @var $this View */
/* @var $item StandingsItem */

?>

<?php Modal::begin([
    'header' => Html::tag('strong', $item->team->name) . ' - детали по турам',
    'toggleButton' => ['label' => $item->team->name, 'class' => 'btn btn-link'],
    'options' => ['tabindex' => false],
    'size' => Modal::SIZE_DEFAULT,
]); ?>
    <div class = "text-center">
    <?php if (isset($item->gameItems)) :?>
        <?php foreach ($item->gameItems as $match) :?>
            <?= Button::widget([
                'label' => $match->tour,
                'options' => [
                    'class' =>  ($match->outcome === GameItem::RESULT_WIN) ? 'btn btn-success' : (($match->outcome === GameItem::RESULT_DRAW) ? 'btn btn-warning' : 'btn btn-danger'),
                    'title' => $match->details,
                    'style' => 'margin-bottom: 5px'
                ]
            ]);?>
            <?php if ($match->tour % 10 == 0) :?>
                <br>
            <?php endif ;?>
        <?php endforeach;?>
    <?php endif ;?>
    </div>
<?php Modal::end();
?>


