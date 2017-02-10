<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 09/02/17
 * Time: 15:50
 */
namespace modules\AOR_Reports\models\query;
include_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'rootPath.php';

class MysqlQuery extends AbstractQuery
{
    public function  __construct()
    {
        parent::__construct();
    }

    public function buildQuery()
    {
        // TODO: Implement buildQuery() method.
    }

}