<?php

use yii\helpers\Html;

$this->title = 'График данных';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php
\yii\helpers\VarDumper::dump($data,7,true);