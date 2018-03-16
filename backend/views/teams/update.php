<?php
/* @var $this yii\web\View */

use core\entities\sf\Country;
use core\forms\sf\TeamForm;

/* @var $model TeamForm */
/* @var $country Country */

$this->title = 'Редактировать команду';
$this->params['breadcrumbs'][] = ['label' => 'Страны', 'url' => ['country/index']];
$this->params['breadcrumbs'][] = ['label' => $country->name, 'url' => ['country/view', 'slug' => $country->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>