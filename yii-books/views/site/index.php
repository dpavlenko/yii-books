<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'My Yii Application';
$this->params['meta_description'] = 'A high-performance PHP framework best for developing web applications. Fast, secure, and professional.';
$this->params['meta_keywords'] = 'yii, yii2, php, framework, web application, high-performance';
?>
<div class="site-index">

    <!-- Hero banner with Yii gradient -->
    <div class="hero-banner text-white rounded-4 p-5 mb-4 position-relative overflow-hidden">
        <?= Html::img(Yii::getAlias('@web/images/yii3_full_white_for_dark.svg'), [
            'alt' => '',
            'class' => 'd-none d-lg-block position-absolute hero-logo',
        ]) ?>
        <div class="position-relative">
            <h1 class="display-5 fw-bold mb-3">Test work</h1>
        </div>
    </div>

    <!-- Extensions grid -->
    <div class="row g-3">
        <div class="col-12">
            <ul>
                <li><a href="/book">Книги</a> </li>
                <li><a href="/author">Авторы</a></li>
                <li><a href="/report">Отчет</a></li>
                <li><a href="/subscription">Подписки</a></li>
            </ul>

        </div>
    </div>

</div>
