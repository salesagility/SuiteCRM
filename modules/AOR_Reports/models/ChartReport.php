<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 09/02/17
 * Time: 15:50
 */
namespace modules\AOR_Reports\models;

class ChartReport extends abstractReport
{
    public function __construct($queryFactory, $markupFactory)
    {
        parent::__construct($queryFactory, $markupFactory);
    }

    public function getContent()
    {
        // TODO: Implement getContent() method.
    }
}