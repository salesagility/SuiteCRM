<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 09/02/17
 * Time: 12:19
 */
namespace modules\AOR_Reports\models\report;
use modules\AOR_Reports\models\markup\MarkupFactory;
use modules\AOR_Reports\models\query\QueryFactory;

include_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'rootPath.php';
include_once ROOTPATH.'/modules/AOR_Reports/models/report/ChartReport.php';
include_once ROOTPATH.'/modules/AOR_Reports/models/query/QueryFactory.php';
include_once ROOTPATH.'/modules/AOR_Reports/models/markup/MarkupFactory.php';

class ReportFactory
{

    public function __construct()
    {

    }

    public static function makeReport($type){
        switch($type){
            case 'chart':
                return new ChartReport(new QueryFactory(),new MarkupFactory());
                break;
            default:
                break;

        }
    }
}