<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/14/2018
 * Time: 2:38 PM
 */

use kartik\widgets\SideNav;
use yii\helpers\Url;
use kartik\icons\Icon;

Icon::map($this);

/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php $this->beginContent('@backend/views/layouts/main.php') ?>

<div class="row">
    <aside id="column-left" class="col-sm-2 hidden-xs" style="margin-top: 70px">
        <?= SideNav::widget([
            'type' => SideNav::TYPE_DEFAULT,
            'heading' => '<i class="glyphicon glyphicon-cog"></i> Администрирование',
            'items' => [
                ['label' => 'Страны', 'icon' => 'globe', 'url' => Url::to(['/country/index']), 'active' => $this->context->id == 'country'],
                ['label' => 'Команды', 'icon' => 'star', 'url' => Url::to(['/team/index']), 'active' => $this->context->id == 'team'],
                ['label' => 'Турниры', 'icon' => 'glass', 'url' => Url::to(['/tournament/index']), 'active' => $this->context->id == 'tournament'],
                ['label' => 'Новости', 'icon' => 'comment', 'url' => Url::to(['/news/index']), 'active' => $this->context->id == 'news'],
                ['label' => 'Пользователи', 'icon' => 'user', 'url' => Url::to(['/user/index']), 'active' => $this->context->id == 'user'],
                ['label' => 'Журнал', 'icon' => 'list-alt', 'url' => Url::to(['/log/index']), 'active' => $this->context->id == 'log'],
            ]
        ]);?>
    </aside>
    <div id="content" class="col-sm-10">
        <?= $content;?>
    </div>
</div>

<?php $this->endContent();?>
