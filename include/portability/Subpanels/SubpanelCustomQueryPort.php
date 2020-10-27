<?php

class SubpanelCustomQueryPort
{

    /**
     * @param SugarBean $bean
     * @param string $subpanel
     * @return array
     */
    public function getQueries(SugarBean $bean, string $subpanel = ''): array
    {

        /* @noinspection PhpIncludeInspection */
        require_once 'include/SubPanel/SubPanelDefinitions.php';

        $spd = new SubPanelDefinitions($bean);
        $subpanel_def = $spd->load_subpanel($subpanel);

        $subpanel_list = array();
        if (method_exists($subpanel_def, 'isCollection')) {
            if ($subpanel_def->isCollection()) {
                if ($subpanel_def->load_sub_subpanels() === false) {
                    $subpanel_list = array();
                } else {
                    $subpanel_list = $subpanel_def->sub_subpanels;
                }
            } else {
                $subpanel_list[] = $subpanel_def;
            }
        } else {
            $GLOBALS['log']->fatal('Subpanel definition should be an aSubPanel');
        }


        return SugarBean::getUnionRelatedListQueries($subpanel_list, $subpanel_def, $bean, '');
    }

    /**
     * @param string $query
     * @return array
     */
    public function runQuery(string $query): array
    {
        $db = DBManagerFactory::getInstance('listviews');
        $result = $db->query($query, true, "SubpanelCustomQueryPort: Error executing custom query");

        return $db->fetchByAssoc($result);
    }

}
