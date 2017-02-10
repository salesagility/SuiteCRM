<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 09/02/17
 * Time: 12:19
 */
namespace modules\AOR_Reports\models\query;
include_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'rootPath.php';

class QueryFactory
{
    public function __construct()
    {

    }

    public function makeQuery($type){
        switch($type){
            case 'MySql':
                return new MysqlQuery();
                break;
            default:
                break;

        }
    }
}