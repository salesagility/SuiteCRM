<?php

namespace SuiteCRM\Api\V8\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use SuiteCRM\Api\Core\Api;
use SuiteCRM\Api\V8\Library\ModuleLib;

class ModuleController extends Api
{
    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function getModuleRecords(Request $req, Response $res, array $args)
    {
        $module = \BeanFactory::getBean($args['module_name']);
        $filter = html_entity_decode($req->getQueryParam('filter', ''));
        $offset = (int)$req->getQueryParam('offset', 0);
        $limit = (int)$req->getQueryParam('limit', -1);
        if (is_object($module)) {
            $lib = new ModuleLib();
            $where = $module->get_where($lib->parseFilter($filter), false, '');
            $records = $module->get_list('', $where, $offset, $limit);

            if (count($records)) {
                foreach ($records['list'] as $record) {
                    $record->fixUpFormatting();
                    $records['records'][] = $record->toArray();
                }
            }
            unset($records['list']);
        } else {
            return $this->generateResponse($res, 400, null, 'Module Not Found');
        }

        return $this->generateResponse($res, 200, $records, 'Success');
    }

    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function getModuleRecord(Request $req, Response $res, array $args)
    {
        $id = $args['id'];
        $module = $args['module_name'];
        $module = \BeanFactory::getBean($module, $id);

        if (!is_object($module)) {
            return $this->generateResponse($res, 404, null, 'Record Not Found');
        }
        $module->fixUpFormatting();

        return $this->generateResponse($res, 200, $module->toArray(), 'Success');
    }

    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function getAvailableModules(Request $req, Response $res, array $args)
    {
        global $container;

        $lib = new ModuleLib();

        $filter = 'all';
        if (!empty($args['filter'])) {
            $filter = $args['filter'];
        }

        if ($container['jwt'] !== null && $container['jwt']->userId !== null) {
            $user = \BeanFactory::getBean('Users', $container['jwt']->userId);
            if ($user !== false) {
                return $this->generateResponse($res, 200, $lib->getAvailableModules($filter, $user), 'Success');
            }
        }

        $GLOBALS['log']->warn(__FILE__.': '.__FUNCTION__.' called but user not found');

        return $this->generateResponse($res, 401, 'No user id', 'Failure');
    }

    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function getModuleLayout(Request $req, Response $res, array $args)
    {
        $lib = new ModuleLib();
        $data = $req->getParsedBody();

        $modules = '';
        if (!empty($data['modules'])) {
            $modules = $data['modules'];
        }

        $views = '';
        if (!empty($data['views'])) {
            $views = $data['views'];
        }

        $types = '';
        if (!empty($data['types'])) {
            $types = $data['types'];
        }

        $hash = 'false';

        if (!empty($data['hash'])) {
            $hash = $data['hash'];
        }

        if (empty($modules)
            || empty($views)
            || empty($types)
            || !is_array($modules)
            || !is_array($views)
            || !is_array($types)
        ) {
            //http://stackoverflow.com/a/10323055
            return $this->generateResponse($res, 400, 'Incorrect parameters', 'Failure');
        } else {
            return $this->generateResponse(
                $res,
                200,
                $lib->getModuleLayout($modules, $views, $types, $hash),
                'Success'
            );
        }
    }

    //Emails?fields[]=name&fields[]=id
    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function getModuleFields(Request $req, Response $res, array $args)
    {
        global $moduleList;
        $lib = new ModuleLib();
        $data = $req->getParsedBody();

        $fields = [];
        if (!empty($data['fields'])) {
            //If the user has entered the parameter as fields[] = xxx
            if (is_array($data['fields'])) {
                $fields = $data['fields'];
            } else {
                //If the user has entered the parameter as fields = xxx

                $fields[] = $data['fields'];
            }
        }

        $module = $args['module'];
        $bean = \BeanFactory::getBean($module);
        if ($bean instanceof \SugarBean) {
            return $this->generateResponse($res, 200, $lib->getModuleFields($module, $fields), 'Success');
        } else {
            $GLOBALS['log']->info(__FILE__.': '.__FUNCTION__.' called but module not matched ('.$module.')');

            return $this->generateResponse($res, 404, 'Non-matched item', 'Failure');
        }
    }

    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function getNoteAttachment(Request $req, Response $res, array $args)
    {
        require_once 'modules/Notes/Note.php';
        $id = $args['id'];

        $note = new \Note();
        $note->retrieve($id);

        if (!$note->ACLAccess('DetailView')) {
            return $this->generateResponse($res, 401, 'Unauthorised', 'Failure');
        }

        $lib = new ModuleLib();

        return $this->generateResponse($res, 200, $lib->getNoteAttachment($note, $id), 'Success');
    }

    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function getModuleRelationships(Request $req, Response $res, array $args)
    {
        //TODO need to check the http return codes for the errors
        global $beanList, $beanFiles;
        $lib = new ModuleLib();
        $data = $req->getParsedBody();

        $module_name = $args['module'];
        $module_id = $args['id'];
        $related_module = $args['related_module'];

        $related_module_query = $data['related_module_query'];

        if (empty($beanList[$module_name]) || empty($beanList[$related_module])) {
            return $this->generateResponse($res, 404, 'Non-matched item', 'Failure');
        }
        $class_name = $beanList[$module_name];
        require_once $beanFiles[$class_name];
        $mod = new $class_name();
        $mod->retrieve($module_id);
        if (!$mod->ACLAccess('DetailView')) {
            return $this->generateResponse($res, 401, 'Unauthorised', 'Failure');
        }

        require_once 'include/SugarSQLValidate.php';
        $valid = new \SugarSQLValidate();
        if (!$valid->validateQueryClauses($related_module_query)) {
            return $this->generateResponse($res, 401, 'Unauthorised', 'Failure');
        }

        $id_list = $lib->get_linked_records($related_module, $module_name, $module_id);

        if ($id_list === false || count($id_list) === 0) {
            return $this->generateResponse($res, 401, 'Unauthorised', 'Failure');
        }

        return $this->generateResponse(
            $res,
            200,
            $lib->getModuleRelationships($related_module, $id_list),
            'Success'
        );
    }

    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function getModuleLinks(Request $req, Response $res, array $args)
    {
        $lib = new ModuleLib();
        $module = $args['module'];
        $bean = \BeanFactory::getBean($module);
        if ($bean instanceof \SugarBean) {
            return $this->generateResponse($res, 200, $lib->getModuleLinks($bean), 'Success');
        } else {
            $GLOBALS['log']->info(__FILE__.': '.__FUNCTION__.' called but module not matched ('.$module.')');

            return $this->generateResponse($res, 404, 'Non-matched item', 'Failure');
        }
    }

    //SuiteCRM/service/api/v8/restapi.php/get_language_definition?modules[]=Accounts&modules[]=Emails
    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function getLanguageDefinition(Request $req, Response $res, array $args)
    {
        $lib = new ModuleLib();
        $data = $req->getParsedBody();

        $modules = '';
        if (!empty($data['modules'])) {
            $modules = $data['modules'];
        }

        $hash = 'false';

        if (isset($data['hash'])) {
            $hash = $data['hash'];
        }

        return $this->generateResponse($res, 200, $lib->getLanguageDefinition($modules, $hash), 'Success');
    }

    //SuiteCRM/service/api/v8/restapi.php/get_last_viewed?modules[]=Accounts&modules[]=Emails
    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function getLastViewed(Request $req, Response $res, array $args)
    {
        global $container, $moduleList;
        $lib = new ModuleLib();
        $data = $req->getParsedBody();

        $modules = '';
        if (!empty($data['modules'])) {
            $modules = $data['modules'];
        }

        if ($container['jwt'] !== null && $container['jwt']->userId !== null) {
            if ($modules !== null && is_array($modules)) {
                $results = [];
                foreach ($modules as $module) {
                    if (in_array($module, $moduleList)) {
                        $results[$module] = $lib->getLastViewed($container['jwt']->userId, $module);
                    } else {
                        $GLOBALS['log']->warn(__FILE__.': '.__FUNCTION__.' called but module not matched');

                        return $this->generateResponse($res, 404, 'Non-matched item', 'Failure');
                    }
                }

                return $this->generateResponse($res, 200, json_encode($results), 'Success');
            } else {
                $GLOBALS['log']->warn(__FILE__.': '.__FUNCTION__.' called but modules are null');

                return $this->generateResponse($res, 400, 'Incorrect parameters', 'Failure');
            }
        } else {
            //The userid was not retrieved from the system
            $GLOBALS['log']->warn(__FILE__.': '.__FUNCTION__.' called but user not found');

            return $this->generateResponse($res, 401, 'No user id', 'Failure');
        }
    }

    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function deleteModuleItem(Request $req, Response $res, array $args)
    {
        global $moduleList;
        $lib = new ModuleLib();
        $module = $args['module'];
        $id = $args['id'];

        $matchingBean = \BeanFactory::getBean($module, $id);
        if ($matchingBean instanceof \SugarBean) {
            $lib->deleteModuleItem($matchingBean, $id);
            return $this->generateResponse($res, 200, null, 'Success');
        } else {
            $GLOBALS['log']->info(
                __FILE__.': '.__FUNCTION__.' called but module not matched.  Module = '.$module.' Id= '.$id
            );

            return $this->generateResponse($res, 404, 'Non-matched item', 'Failure');
        }
    }

    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function createRelationship(Request $req, Response $res, array $args)
    {
        $lib = new ModuleLib();
        $data = $req->getParsedBody();

        $moduleName = $data['module_name'];
        $moduleId = $data['module_id'];
        $linkFieldName = $data['link_field_name'];
        $relatedIds = $data['related_ids'];
        $nameValues = $data['name_value_list'];

        if (empty($moduleName)
            || empty($moduleId)
            || empty($linkFieldName)
            || !is_array($relatedIds)
            || empty($relatedIds)
        ) {
            return $this->generateResponse($res, 400, 'Incorrect parameters', 'Failure');
        } else {
            return $this->generateResponse(
                $res,
                200,
                $lib->createRelationship($moduleName, $moduleId, $linkFieldName, $relatedIds, $nameValues),
                'Success'
            );
        }
    }

    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function deleteRelationship(Request $req, Response $res, array $args)
    {
        $lib = new ModuleLib();
        $data = $req->getParsedBody();

        $moduleName = $data['module_name'];
        $moduleId = $data['module_id'];
        $linkFieldName = $data['link_field_name'];
        $relatedIds = $data['related_ids'];
        $nameValues = $data['name_value_list'];

        if (empty($moduleName)
            || empty($moduleId)
            || empty($linkFieldName)
            || !is_array($relatedIds)
            || empty($relatedIds)
        ) {
            return $this->generateResponse($res, 400, 'Incorrect parameters', 'Failure');
        } else {
            return $this->generateResponse(
                $res,
                200,
                $lib->deleteRelationship($moduleName, $moduleId, $linkFieldName, $relatedIds, $nameValues),
                'Success'
            );
        }
    }

    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function createRelationships(Request $req, Response $res, array $args)
    {
        $lib = new ModuleLib();
        $data = $req->getParsedBody();

        $moduleNames = $data['module_names'];
        $moduleIds = $data['module_ids'];
        $linkFieldNames = $data['link_field_names'];
        $relatedIds = $data['related_ids'];
        $nameValues = $data['name_value_list'];

        if (!is_array($moduleNames) || !is_array($moduleIds)
            || !is_array($linkFieldNames) || !is_array($relatedIds)
            || empty($moduleNames) || empty($moduleIds)
            || empty($linkFieldNames) || empty($relatedIds)
            || sizeof($moduleNames) != sizeof($moduleIds) || sizeof($moduleNames) != sizeof($linkFieldNames)
            || sizeof($moduleNames) != sizeof($relatedIds)
        ) {
            return $this->generateResponse($res, 400, 'Incorrect parameters', 'Failure');
        } else {
            return $this->generateResponse(
                $res,
                200,
                $lib->createRelationships($moduleNames, $moduleIds, $linkFieldNames, $relatedIds, $nameValues),
                'Success'
            );
        }
    }

    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function deleteRelationships(Request $req, Response $res, array $args)
    {
        $lib = new ModuleLib();
        $data = $req->getParsedBody();

        $moduleNames = $data['module_names'];
        $moduleIds = $data['module_ids'];
        $linkFieldNames = $data['link_field_names'];
        $relatedIds = $data['related_ids'];
        $nameValues = $data['name_value_list'];

        if (!is_array($moduleNames) || !is_array($moduleIds)
            || !is_array($linkFieldNames) || !is_array($relatedIds)
            || !is_array($nameValues) || empty($moduleNames)
            || empty($moduleIds) || empty($linkFieldNames)
            || empty($relatedIds) || empty($nameValues)
            || sizeof($moduleNames) != sizeof($moduleIds)
            || sizeof($moduleNames) != sizeof($linkFieldNames)
            || sizeof($moduleNames) != sizeof($relatedIds)
        ) {
            return $this->generateResponse($res, 400, 'Incorrect parameters', 'Failure');
        } else {
            return $this->generateResponse(
                $res,
                200,
                $lib->deleteRelationships($moduleNames, $moduleIds, $linkFieldNames, $relatedIds, $nameValues),
                'Success'
            );
        }
    }

    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function updateModuleItem(Request $req, Response $res, array $args)
    {
        global $moduleList;
        $lib = new ModuleLib();
        $module = $args['module'];
        $id = $args['id'];
        $data = $req->getParsedBody();

        $matchingBean = \BeanFactory::getBean($module, $id);
        if ($matchingBean instanceof \SugarBean) {
            $GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], $module);
            $lib->updateModuleItem($matchingBean, $data);
            return $this->generateResponse($res, 200, null, 'Success');
        } else {
            $GLOBALS['log']->info(
                __FILE__.': '.__FUNCTION__.' called but module not matched.  Module = '.$module.' Id= '.$id
            );

            return $this->generateResponse($res, 404, 'Non-matched item', 'Failure');
        }
    }

    /**
     * @param Request  $req
     * @param Response $res
     * @param array $args
     *
     * @return Response
     */
    public function createModuleItem(Request $req, Response $res, array $args)
    {
        global $moduleList;
        $module = $args['module'];
        $lib = new ModuleLib();
        $data = $req->getParsedBody();

        if (in_array($module, $moduleList)) {
            return $this->generateResponse($res, 200, $lib->createModuleItem($module, $data), 'Success');
        } else {
            $GLOBALS['log']->info(__FILE__.': '.__FUNCTION__.' called but module not matched.  Module = '.$module);

            return $this->generateResponse($res, 404, 'Non-matched item', 'Failure');
        }
    }
}
