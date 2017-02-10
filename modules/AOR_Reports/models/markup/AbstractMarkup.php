<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 09/02/17
 * Time: 15:46
 */
namespace modules\AOR_Reports\models\markup;
use modules\AOR_Reports\models\markup\MarkupInterface;

include_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'rootPath.php';

abstract class AbstractMarkup implements MarkupInterface
{

    public function __construct()
    {
    }

    abstract public function buildMarkup();
}