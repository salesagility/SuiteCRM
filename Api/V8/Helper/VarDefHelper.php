<?php
namespace Api\V8\Helper;

class VarDefHelper
{
    /**
     * @param \SugarBean $bean
     *
     * @return void
     */
    public function getAllRelationships(\SugarBean $bean)
    {
        $tempBean = \BeanFactory::getBean($bean->module_name,$bean->id);
        $relations = [];
        $linkedFields = $bean->get_linked_fields();
        array_push($linkedFields, 'Email_addresses');

        foreach ($linkedFields as $relation => $varDef) {
            if (isset($varDef['module']) && $bean->load_relationship($relation)) {
                $relations[$relation] = $varDef['module'];
            }
        }

        $email = [
            'email_addresses' => 'EmailAddresses'
        ];

        $bean->load_relationship('email_addresses');
        $emailIds = $bean->email_addresses->get();

        if (!empty($emailIds)){
            $relations = array_merge($relations, $email);
        }

        return $relations;
    }
}
