<?php

use yii\helpers\Html;
use dosamigos\chartjs\ChartJs;

$this->title = 'График данных';
?>

<h1><?= Html::encode($this->title) ?></h1>

<table class="table">
  <tr>
    <?php foreach ($data['info'] as $info) : ?>
      <td><?= $info; ?></td>
    <?php endforeach; ?>
  </tr>
</table>
<?php
//\yii\helpers\VarDumper::dump($data,7,true);
?>

<?= ChartJs::widget([
  'type' => 'line',
  'options' => [
    'height' => 200,
  ],
  'clientOptions' => [
    'maintainAspectRatio' => false
  ],
  'data' => [
    'labels' => $data['chart_labels'],
    'datasets' => [
      [
        'label' => 'Profit',
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
