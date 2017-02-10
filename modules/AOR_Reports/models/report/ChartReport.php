<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 09/02/17
 * Time: 15:50
 */
namespace modules\AOR_Reports\models\report;

include_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'rootPath.php';
include_once ROOTPATH.'/modules/AOR_Reports/models/report/AbstractReport.php';

use modules\AOR_Reports\models\markup\MarkupInterface;
use modules\AOR_Reports\models\query\QueryInterface;


class ChartReport extends AbstractReport
{
    public function  __construct($queryFactory,$markupFactory)
    {
        parent::__construct($queryFactory, $markupFactory);
    }

    protected function generateReport()
    {
        // TODO: Implement generateReport() method.
        return 'hello world';
    }


}