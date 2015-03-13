<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 13/03/15
 * Time: 14:44
 */

include_once("include/InlineEditing/InlineEditing.php");

class HomeController extends SugarController{


    public function action_getEditFieldHTML(){

        if($_REQUEST['field'] && $_REQUEST['id'] && $_REQUEST['current_module'] && $_REQUEST['value']){

            echo getEditFieldHTML($_REQUEST['current_module'], $_REQUEST['field'], '' , 'EditView', $_REQUEST['value']);

        }

    }

    public function action_saveHTMLField(){



    }

}