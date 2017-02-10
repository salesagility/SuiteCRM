<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 09/02/17
 * Time: 12:19
 */
namespace modules\AOR_Reports\models\markup;
include_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'rootPath.php';

class MarkupFactory
{
    public function __construct()
    {

    }

    public function makeMarkup($type){
        switch($type){
            case 'chart':
                return new ChartMarkup();
                break;
            default:
                break;

        }
    }
}