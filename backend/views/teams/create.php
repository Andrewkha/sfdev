<?php
/* @var $this yii\web\View */

use core\entities\sf\Country;
use core\forms\sf\TeamForm;

/* @var $model TeamForm */
/* @var $country Country */

$this->title = 'Создать команду';
$this->params['breadcrumbs'][] = ['label' => 'Страны', 'url' => ['countries/index']];
$this->params['breadcrumbs'][] = ['label' => $country->name, 'url' => ['countries/view', 'slug' => $country->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>