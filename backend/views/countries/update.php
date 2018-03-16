<?php
/* @var $this yii\web\View */

use core\entities\sf\Country;
use core\forms\sf\CountryForm;

/* @var $country Country*/
/* @var $model CountryForm */
$this->title = 'Update Brand: ' . $country->name;
$this->params['breadcrumbs'][] = ['label' => 'Страны', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $country->name, 'url' => ['view', 'slug' => $country->slug]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="country-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>