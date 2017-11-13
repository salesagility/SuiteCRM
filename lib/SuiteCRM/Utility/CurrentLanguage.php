<?php
/**
 * Created by PhpStorm.
 * User: gyula
 * Date: 10/10/17
 * Time: 15:10
 */

namespace SuiteCRM\Utility;


class CurrentLanguage
{

    public function getCurrentLanguage() {
        global $current_language;
        return $current_language;
    }

}