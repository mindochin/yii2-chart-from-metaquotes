<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\UploadForm;
use yii\web\UploadedFile;

class AppController extends Controller
{
    public function actionIndex()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->dataFile = UploadedFile::getInstance($model, 'dataFile');
            if ($model->validate()) {
                // file is uploaded successfully
                if ($html = file_get_contents($model->dataFile->tempName)) {
                    $data = $model->parseData($html);

                    if ($data['success'] === true) {
                        \Yii::$app->session->setFlash('success', 'Данные загружены');
                        return $this->render('chart', ['data' => $data]);
                    } else {
                        \Yii::$app->session->setFlash('error', 'Данные не обнаружены');
                    }
                }
            }
        }

        return $this->render('index', ['model' => $model]);
    }
}
