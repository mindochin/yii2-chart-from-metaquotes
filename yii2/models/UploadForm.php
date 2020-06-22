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
     * @return array result parse
     */
    public function parseData($html)
    {        
        $result = []; // result
        $result['info'] = '';
        $result['data'] = [];
        $crawler = new Crawler($html);
        $crawler = $crawler->filter('tr');

        $crawler->each(function ($tr, $i) use(&$result) {           
            $arrTd = []; //array of cells
        
            $tr->filter('td')->each(function ($td, $i) use (&$arrTd) {
                $arrTd[$i] = $td->text(null);  // null if no node            
            });
           

            // first row contain info of account
            if($i === 0) {
                $result['info'] = $arrTd; 
            }
            // these lines contain data
            else if($i > 0 and $arrTd['2'] == 'buy')
                $result['data'][] = $arrTd;
        });

        return $result;
    }
}
