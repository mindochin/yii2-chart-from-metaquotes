<?php

use yii\helpers\Html;
use yii\helpers\Url;
use phpnt\chartJS\ChartJs;

$this->title = 'График данных';

$this->registerJsFile('https://cdn.jsdelivr.net/npm/hammerjs@2.0.8');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7', ['depends' => [\phpnt\chartJS\ChartJSAsset::className()]]);
?>

<h1><?= Html::encode($this->title) ?></h1>
<? //\yii\helpers\VarDumper::dump($data,7,true); // what's inside? ?>
<table class="table">
  <tr>
    <?php foreach ($data['info'] as $info) : ?>
      <td><?= $info; ?></td>
    <?php endforeach; ?>
  </tr>
</table>

<div style="height: 400px; margin-bottom: 1em;">
  <?= Chartjs::widget([
    'type' => Chartjs::TYPE_LINE,
    'options'   => [
      'maintainAspectRatio' => false,
      'plugins' => [
        'zoom' => [
          'pan' => [
            'enabled' => true,
            'mode' => 'x'
          ],
          'zoom' => [
            'enabled' => true,           
            'mode' => 'x',          
            'sensitivity' => 0.5,
          ]
        ]
      ]
    ],
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

<?= Html::a('Загрузить еще', Url::home(), ['class' => 'btn btn-success', 'role' => 'button']) ?>