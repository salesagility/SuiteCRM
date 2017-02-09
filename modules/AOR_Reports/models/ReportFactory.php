<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 09/02/17
 * Time: 12:19
 */
namespace modules\AOR_Reports\models;

class ReportFactory
{
    public function __construct()
    {

    }

    public function makeReport($type){
        switch($type){
            case 'chart':
                return new ChartReport();
                break;
            default:
                break;

        }
    }
}