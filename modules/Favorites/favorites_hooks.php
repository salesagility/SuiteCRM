<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 15/05/15
 * Time: 09:57
 */

require_once("modules/Favorites/Favorites.php");

class favorites_hooks{

    public function remove_favorite($bean){

       $favorites_class = new Favorites();
       $favorite_id = $favorites_class->getFavoriteID($bean->module_dir,$bean->id);

        if($favorite_id){
            $deleted = $favorites_class->deleteFavorite($favorite_id);
            return $deleted;
        }else{
            return false;
        }

    }

}