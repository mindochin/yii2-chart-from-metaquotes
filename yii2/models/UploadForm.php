<?php

namespace app\models;

use Symfony\Component\DomCrawler\Crawler;
use yii\base\Model;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $dataFile;

    public function rules()
    {
        return [
            [['dataFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'html', 'checkExtensionByMimeType' => false],
        ];
    }

    /**
     * @return array attribute labels
     */
    public function attributeLabels()
    {
        return [
            'dataFile' => 'Файл с данными',
        ];
    }
    /**
     * @return array attribute hints
     */
    public function attributeHints()
    {
        return [
            'dataFile' => 'Должен быть в формате html, табличная форма',
        ];
    }
    /**
     * @return array result parse
     */
    public function parseData($html)
    {
        $result = []; // result
        $result['info'] = ''; // info of account
        $result['data'] = []; // data of source
        $result['chart_data'] = []; // data for chart
        $result['chart_labels'] = []; // labels for chart
        $result['success'] = false; // data obtained

        /**
         * result mining))
         */
        $crawler = new Crawler($html);
        $crawler = $crawler->filter('tr');

        $crawler->each(function ($tr, $i) use (&$result) {
            $arr_td = []; //array of cells

            $tr->filter('td')->each(function ($td, $i) use (&$arr_td) {
                $arr_td[$i] = $td->text(null);  // null if no node            
            });

            // first row contain info of account
            if ($i === 0) {
                $result['info'] = $arr_td;
            }
            // these lines contain data
            else if ($i > 0 and ($arr_td['2'] == 'buy' or $arr_td['2'] == 'balance'))
                $result['data'][] = $arr_td;
        });

        /**
         * processing result
         */
        $first_balance = 0; // start amount
        $balance = 0; // current amount
        $chart_data = []; // data for chart
        $chart_labels = []; // labels for chart
        foreach ($result['data'] as $data) {
            $chart_labels[] = $data['1'];

            if ($data['2'] == 'balance') {
                $data['4'] = preg_replace("/[^x\d|*\.-]/", "", $data['4']); // need only number

                if ($first_balance === 0) {
                    $first_balance = $balance = $chart_data[] = floatval($data['4']);
                } else
                    $chart_data[] = $balance = round($balance + floatval($data['4']), 2);
            } else {
                $chart_data[] = $balance = round($balance + floatval($data['13']), 2);
            }
        }

        if (!empty($result['info']) && !empty($chart_data) && !empty($chart_labels)) { // yes, it`s ok
            $result['success'] = true;
            $result['chart_data'] = $chart_data;
            $result['chart_labels'] = $chart_labels;
        }

        $result['data'] = []; // clear

        return $result;
    }
}
