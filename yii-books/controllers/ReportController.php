<?php

namespace app\controllers;

use app\models\Author;

class ReportController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $authors = Author::getTop10();

        return $this->render('index', [
            'authors' => $authors
        ]);
    }

}
