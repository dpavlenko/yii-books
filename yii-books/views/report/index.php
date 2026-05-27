<?php
/** @var yii\web\View $this */

use yii\helpers\Html;

//echo '<pre>';
//var_dump($authors);
//echo '</pre>';
//exit('test');
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>ОП 10 авторов, выпустившие больше книг за какой-то год</h1>
            <table class="table">
                <thead>
                <tr>
                    <th><strong>ID</strong></th>
                    <th><strong>Имя</strong></th>
                    <th><strong>Отчество</strong></th>
                    <th><strong>Фамилия</strong></th>
                    <th><strong>Количество книг</strong></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($authors as $author): ?>
                <tr>
                    <td><?=  Html::encode($author['id']) ?></td>
                    <td><?=  Html::encode($author['name']) ?></td>
                    <td><?=  Html::encode($author['surname']) ?></td>
                    <td><?=  Html::encode($author['second_name']) ?></td>
                    <td><?=  Html::encode($author['book_count']) ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
