<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Загрузка файл с данными';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'dataFile')->fileInput(['class'=>'form-control']) ?>

    <button type="submit" value="Загрузить файл" name="file-submit" class="btn btn-primary">Загрузить файл</button>

<?php ActiveForm::end() ?>
