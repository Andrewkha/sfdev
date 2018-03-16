<?php
/* @var $this yii\web\View */

use core\forms\sf\CountryForm;

/* @var $model CountryForm */

$this->title = 'Создать страну';
$this->params['breadcrumbs'][] = ['label' => 'Страны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>