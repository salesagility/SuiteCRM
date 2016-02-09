<?php
namespace SuiteCRM\Api\V8\Controller;

use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;

use SuiteCRM\Api\Core\Api;
use SuiteCRM\Api\V8\Library\ModuleLib;

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

    public function getAvailableModules(Request $req, Response $res, $args){
        global $container;

        $lib = new ModuleLib();

        $filter = 'all';
        if(!empty($args['filter']))
            $filter = $args['filter'];

        if ($container["jwt"] !== null && $container["jwt"]->userId !== null) {
            $user = \BeanFactory::getBean('Users', $container["jwt"]->userId);
            if ($user === false) {
                return $this->generateResponse($res,401,'No user id','Failure');
            }
            else
            {
                return $this->generateResponse($res,200,$lib->getAvailableModules($filter,$user),'Success');
            }

        } else {
            $GLOBALS['log']->warn(__FILE__.': ' . __FUNCTION__ . ' called but user not found');
            return $this->generateResponse($res,401,'No user id','Failure');
        }
    }

    //get_module_layout?modules[]=Accounts&views[]=Detail&types[]=default
    public function getModuleLayout(Request $req, Response $res, $args){
        $lib = new ModuleLib();

        $modules = '';
        if(!empty($_REQUEST['modules']))
            $modules = $_REQUEST['modules'];

        $views = '';
        if(!empty($_REQUEST['views']))
            $views = $_REQUEST['views'];

        $types = '';
        if(!empty($_REQUEST['types']))
            $types = $_REQUEST['types'];

        $hash = 'false';

        if (!empty($_REQUEST['hash']))
            $hash = $_REQUEST['hash'];

        if (empty($modules) || empty($views) || empty($types) || !is_array($modules)|| !is_array($views) || !is_array($types)) {//http://stackoverflow.com/a/10323055
            return $this->generateResponse($res,400,'Incorrect parameters','Failure');
        } else {
            return $this->generateResponse($res,200,$lib->getModuleLayout($modules,$views,$types,$hash),'Success');
        }
    }

    //Emails?fields[]=name&fields[]=id
    public function getModuleFields(Request $req, Response $res, $args)
    {
        {
            global $moduleList;
            $lib = new ModuleLib();
            $output = $args;
            $fields = array();
            if (!empty($_REQUEST['fields'])) {
                //If the user has entered the parameter as fields[] = xxx
                if (is_array($_REQUEST['fields']))
                    $fields = $_REQUEST['fields'];
                else //If the user has entered the parameter as fields = xxx
                    $fields[] = $_REQUEST['fields'];
            }

            $module = $args['module'];
            if (in_array($module, $moduleList)) {
                return $this->generateResponse($res, 200, $lib->getModuleFields($module,$fields), 'Success');

            } else {
                $GLOBALS['log']->info(__FILE__ . ': ' . __FUNCTION__ . ' called but module not matched (' . $module . ')');
                return $this->generateResponse($res, 404, 'Non-matched item', 'Failure');
            }
        }
    }

    public function getModuleLinks(Request $req, Response $res, $args){
        global $moduleList;
        $lib = new ModuleLib();
        $module = $_REQUEST['module'];
        if (in_array($module, $moduleList)) {
            $bean = \BeanFactory::getBean($module);
            if (!empty($bean)) {
                return $this->generateResponse($res,200,$lib->getModuleLinks($bean),'Success');
            } else {
                $GLOBALS['log']->info(__FILE__.': ' . __FUNCTION__ . ' called but module not matched (' . $module . ')');
                return $this->generateResponse($res,404,'Non-matched item','Failure');
            }
        } else {
            $GLOBALS['log']->info(__FILE__.': ' . __FUNCTION__ . ' called but module not matched (' . $module . ')');
            return $this->generateResponse($res,404,'Non-matched item','Failure');
        }
    }

    //SuiteCRM/service/api/v8/restapi.php/get_language_definition?modules[]=Accounts&modules[]=Emails
    public function getLanguageDefinition(Request $req, Response $res, $args){

        $lib = new ModuleLib();

        $modules = '';
        if(!empty($_REQUEST['modules']))
            $modules =$_REQUEST['modules'];

        $hash = 'false';

        if (isset($_REQUEST['hash']))
            $hash = $_REQUEST['hash'];

        return $this->generateResponse($res,200,$lib->getLanguageDefinition($modules,$hash),'Success');

    }

    //SuiteCRM/service/api/v8/restapi.php/get_last_viewed?modules[]=Accounts&modules[]=Emails
    function getLastViewed(Request $req, Response $res, $args)
    {
            global $container, $moduleList;
            $lib = new ModuleLib();

            $modules = '';
            if (!empty($_REQUEST['modules']))
                $modules = $_REQUEST['modules'];

            if ($container["jwt"] !== null && $container["jwt"]->userId !== null) {
                if ($modules !== null && is_array($modules)) {
                    $results = array();
                    foreach ($modules as $module) {

                        if (in_array($module, $moduleList)) {
                            $results[$module] = $lib->getLastViewed($container["jwt"]->userId, $module);
                        } else {
                            $GLOBALS['log']->warn(__FILE__ . ': ' . __FUNCTION__ . ' called but module not matched');
                            return $this->generateResponse($res, 404, 'Non-matched item', 'Failure');
                        }
                    }
                    return $this->generateResponse($res, 200, json_encode($results), 'Success');
                } else {
                    $GLOBALS['log']->warn(__FILE__ . ': ' . __FUNCTION__ . ' called but modules are null');
                    return $this->generateResponse($res, 400, 'Incorrect parameters', 'Failure');
                }
            } else {//The userid was not retrieved from the system
                $GLOBALS['log']->warn(__FILE__ . ': ' . __FUNCTION__ . ' called but user not found');
                return $this->generateResponse($res, 401, 'No user id', 'Failure');
            }
        }




}