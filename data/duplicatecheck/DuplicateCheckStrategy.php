<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

/**
 * Base class for duplicate check strategy implementations
 * @abstract
 * @api
 */
abstract class DuplicateCheckStrategy
{
    /**
     * Parent bean
     * @var SugarBean
     */
    protected $bean;

    /**
     * @param SugarBean $bean
     * @param array $metadata
     */
    public function __construct($bean, $metadata)
    {
        $this->bean = $bean;
        $this->setMetadata($metadata);
    }

    /**
     * Parse the provided metadata into appropriate protected properties
     *
     * @abstract
     * @access protected
     */
    abstract protected function setMetadata($metadata);

    /**
     * Finds possible duplicate records for a given set of field data.
     *
     * @abstract
     * @access public
     */
    abstract public function findDuplicates();
}