<?php

namespace SuiteCRM\helpers;

class api{

    public function getModuleRecords($module_name){

        $module = \BeanFactory::getBean($module_name);
        if(is_object($module)){
           return $module->get_list();
        }

    }


}