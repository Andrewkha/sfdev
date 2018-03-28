<?php
/* @var $this yii\web\View */

use core\forms\sf\TournamentForm;

/* @var $model TournamentForm */

$this->title = 'Создать турнир';
$this->params['breadcrumbs'][] = ['label' => 'Турниры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>