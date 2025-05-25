<?php

use app\models\Author;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'front_page')->fileInput(); ?>

    <?= $form->field($model, 'author_ids')->checkboxList(
        \yii\helpers\ArrayHelper::map(Author::find()->all(), 'id', 'second_name'),
        [
            'item' => function ($index, $label, $name, $checked, $value) {
                $checkedAttribute = $checked ? 'checked' : '';
                return '<div class="custom-control custom-checkbox">' .
                    '<input type="checkbox" data-checked="' . $checked . '"  ' . ($checked ? 'checked="checked"' : ''). ' name="' . $name . '" value="' . $value . '" ' . $checkedAttribute . ' id="check-' . $index . '" class="custom-control-input">' .
                    '<label class="custom-control-label" for="check-' . $index . '">' . $label . '</label>' .
                    '</div>';
            }
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
