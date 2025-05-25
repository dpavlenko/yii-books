<?php

use app\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'year',
            'description:ntext',
            'isbn',
            [
                'attribute' => 'authors', // Or any unique alias
                'label' => 'Authors',
                'value' => function ($model) {
                    // Extract and implode category names
                    return implode(', ', \yii\helpers\ArrayHelper::map($model->authors, 'id', 'name'));
                },
                'format' => 'html', // Use 'raw' if you are adding HTML tags like badges
            ],
            [
                'attribute' => 'front_page',
                'format' => 'html',
                'value' => function ($data) {
                    return $data->front_page ? '<img src="' . $data->getImageUrl() . '" width="50" />' : '';
                },
            ],
            //'front_page',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
