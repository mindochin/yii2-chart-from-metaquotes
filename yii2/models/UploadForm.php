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
            [['dataFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'html'],
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
     * @return boolean process uploads
     */
    public function parseData($html)
    {
        $data = null;
        $crawler = new Crawler($html);
        $crawler = $crawler->filter('tr');

        $arrTr = [];
        $crawler = $crawler->each(function ($tr, $i) use(&$arrTr) {
            //\yii\helpers\VarDumper::dump($tr,7,true);
            $arrTd = [];
            $tr->filter('td')->each(function ($td, $i) use (&$arrTd) {
                $arrTd[] = $td->text(null);
                //if($i == 2 and $td->text() == 'buy') {                }
            });
            $arrTr[] = $arrTd;
        });

        /*foreach ($crawler as $td) {            
            $data[] = $td;//->nodeName;
        }*/

        return $arrTr;
    }
}
