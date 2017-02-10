<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 09/02/17
 * Time: 15:46
 */
namespace modules\AOR_Reports\models\query;
include_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'rootPath.php';

abstract class AbstractQuery implements QueryInterface
{

    public function __construct()
    {
    }

    abstract public function buildQuery();
}