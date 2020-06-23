<?php

use yii\helpers\Html;
use phpnt\chartJS\ChartJs;

$this->title = 'График данных';
?>

<h1><?= Html::encode($this->title) ?></h1>
<? \yii\helpers\VarDumper::dump($data,7,true);?>
<table class="table">
  <tr>
    <?php foreach ($data['info'] as $info) : ?>
      <td><?= $info; ?></td>
    <?php endforeach; ?>
  </tr>
</table>

<div style="height: 400px; margin-bottom: 1em;">
  <?= ChartJs::widget([
    'type' => ChartJs::TYPE_LINE,
    'options'   => ['maintainAspectRatio' => false],
    'data' => [
      'labels' => $data['chart_labels'],
      'datasets' => [
        [
          'label' => 'Balance',
          'backgroundColor' => "rgba(179,181,198,0.2)",
          'borderColor' => "rgba(179,181,198,1)",
          'pointBackgroundColor' => "rgba(179,181,198,1)",
          'pointBorderColor' => "#fff",
          'pointHoverBackgroundColor' => "#fff",
          'pointHoverBorderColor' => "rgba(179,181,198,1)",
          'data' => $data['chart_data']
        ],
      ]
    ]
  ]);
  ?>
</div>

<?= Html::a('Загрузить еще', '/', ['class' => 'btn btn-success', 'role' => 'button']) ?>