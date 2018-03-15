<?php
/* @var $this yii\web\View */

use core\entities\sf\Country;

/* @var $model Country */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Страны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>