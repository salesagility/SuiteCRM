<?php
namespace SuiteCRM\Controller;
use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;


class ModuleController extends Api{

    public function getModuleRecords(Request $req, Response $res, $args){


        $module = \BeanFactory::getBean($args['module_name']);
        if(is_object($module)){
            $records = $module->get_full_list();

            if(count($records)){
                foreach($records as $record){
                    $return_records[] = $record->toArray();
                }
            }


        }else{
            return $this->generateResponse($res, 400,NULL,'Module Not Found');

        }

        return $this->generateResponse($res,200,$return_records,'Success');

    }




}