<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use core\entities\user\User;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<body style ="padding-top: 80px;">
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $urlManager = Yii::$app->get('frontendUrlManager');

    $menuItems = [
        ['label' => 'Frontend', 'url' => $urlManager->createAbsoluteUrl(['/site/index'])],
    ];

    if (Yii::$app->user->can('admin')) {
        $menuItems[] = [
            'label' => 'Администрирование',
            'items' => [
                ['label' => 'Страны', 'url' => ['/countries/index']],
                '<li class="divider"></li>',
                ['label' => 'Турниры', 'url' => ['/tournaments/index']],
                '<li class="divider"></li>',
                ['label' => 'Новости', 'url' => ['/news/index']],
                '<li class="divider"></li>',
                ['label' => 'Пользователи', 'url' => ['/user/index']],
                '<li class="divider"></li>',
                ['label' => 'Журнал', 'url' => ['/log/index']],
            ]
        ];
    }

    if (!Yii::$app->user->isGuest) {

        $menuItems[] = [
            'label' => Yii::$app->user->identity->username,
            'items' => [
                ['label' => 'Мои турниры', 'url' => $urlManager->createAbsoluteUrl(['/tournaments/index'])],
                '<li class="divider"></li>',
                ['label' => 'Профиль', 'url' => $urlManager->createAbsoluteUrl(['/profile/index'])],
                '<li class="divider"></li>',
                ['label' => 'Выход', 'url' => ['/auth/auth/logout'], 'linkOptions' => ['data-method' => 'post']]
            ],
        ];

        $menuItems[] = [
            'label' => Html::img(Yii::$app->user->identity->getThumbFileUrl('avatar', 'menuPic', User::DEFAULT_AVATAR_PATH . '_menuPic.jpg')),
            'url' => $urlManager->createAbsoluteUrl(['/profile'])
        ];
    } else {

        $menuItems = [
            ['label' => 'Login', 'url' => ['/auth/auth/login']],
        ];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container-fluid">
        <div class="row">
            <?= Breadcrumbs::widget([
                'options' => [
                    'class' => 'col-xs-12 col-xs-offset-0 col-md-offset-1 col-md-10 breadcrumb'
                ],
                'links' => $this->params['breadcrumbs'] ?? [],
            ]) ?>
        </div>
        <div class="row">
            <div class="col-xs-12 col-xs-offset-0 col-md-offset-1 col-md-10">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
