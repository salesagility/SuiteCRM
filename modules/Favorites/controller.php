<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 07/05/15
 * Time: 10:58
 */

include_once('modules/Favorites/Favorites.php');

class FavoritesController extends SugarController{

    public function action_create_record(){
        global $current_user;

        $favorite = BeanFactory::newBean('Favorites');
        $favorite->name = $_REQUEST['record_module'] . ' ' . $_REQUEST['record_id'] . ' ' . $current_user->id;
        $favorite->parent_type = $_REQUEST['record_module'];
        $favorite->parent_id = $_REQUEST['record_id'];
        $favorite->assigned_user_id = $current_user->id;
        $favorite->save();
        echo json_encode($favorite->id);
    }

    public function action_remove_record(){
        global $current_user;

        $favourite_class = new Favorites();
        $favorite_id = $favourite_class->getFavoriteID($_REQUEST['record_module'],$_REQUEST['record_id']);

        if($favorite_id){
            $deleted =  $favourite_class->deleteFavorite($favorite_id);
            echo json_encode($deleted);
        }else{
            echo json_encode(false);
        }

    }

    public function action_check_favorite(){
        global $current_user;
        $favourite_class = new Favorites();
        $return =  $favourite_class->getFavoriteID($_REQUEST['record_module'],$_REQUEST['record_id']);
        echo json_encode($return);
    }

    public function action_get_sidebar_elements(){
        $favourite_class = new Favorites();
        $return = $favourite_class->getCurrentUserSidebarFavorites($_REQUEST['record_id']);
        echo json_encode($return);
    }

}