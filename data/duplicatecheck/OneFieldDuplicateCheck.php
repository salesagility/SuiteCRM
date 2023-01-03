<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class OneFieldDuplicateCheck extends DuplicateCheckStrategy
{

    protected $field;

    public function setMetadata($metadata)
    {
        if (isset($metadata['field'])) {
            $this->field = $metadata['field'];
        }
    }

    public function findDuplicates()
    {
        if (empty($this->field)){
            return null;
        }

        if(is_array($this->field)){
            $arr = [];
            foreach($this->field as $key){
                $arr[$key] = $this->bean->{$key};
            }
        } else {
            $arr = array( $this->field => $this->bean->{$this->field});
        }

        //Clone record before find duplicates
        $cloneCpy = clone $this->bean;
        $currentId = $this->bean->id;
        $result = $cloneCpy->retrieve_by_string_fields( $arr );

        if($result == null){ return null; }

        // Same Record
        if (!empty($this->bean->id) && ($result->id == $currentId)) {
            return null;
        }

        $current = $this->bean->retrieve($currentId);
        return array('actual' => $current, 'record' => $result, 'arr' => $arr);
    }
}
