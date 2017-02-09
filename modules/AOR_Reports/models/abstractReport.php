<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 09/02/17
 * Time: 15:46
 */
namespace modules\AOR_Reports\models;

abstract class abstractReport implements iReport
{
    private $queryFactory;
    private $markupFactory;

    public function __construct($queryFactory, $markupFactory)
    {
        $this->queryFactory = $queryFactory;
        $this->markupFactory = $markupFactory;
    }

    abstract public function getContent();
}