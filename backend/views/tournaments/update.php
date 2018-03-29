<?php
/* @var $this yii\web\View */

use core\entities\sf\Tournament;
use core\forms\sf\TournamentForm;

/* @var $model TournamentForm */
/* @var $tournament Tournament */

$this->title = 'Редактировать турнир' . $tournament->name;
$this->params['breadcrumbs'][] = ['label' => 'Турниры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tournament->name, 'url' => ['view', 'slug' => $tournament->slug]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="tournament-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>