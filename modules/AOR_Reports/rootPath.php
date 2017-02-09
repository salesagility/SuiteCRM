<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 09/02/17
 * Time: 13:31
 */

$rootpath = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR;
$realroot = realpath($rootpath);
define('ROOTPATH',$realroot);