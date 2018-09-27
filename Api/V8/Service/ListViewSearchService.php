<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

namespace Api\V8\Service;

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\JsonApi\Helper\AttributeObjectHelper;
use Api\V8\JsonApi\Helper\PaginationObjectHelper;
use Api\V8\JsonApi\Helper\RelationshipObjectHelper;
use Api\V8\JsonApi\Response\AttributeResponse;
use Api\V8\Param\ListViewSearchParams;
use ListViewFacade;
use SuiteCRM\LangText;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

include_once __DIR__ . '/../../../include/ListView/ListViewFacade.php';

/**
 * ListViewSearchService
 *
 * @author gyula
 */
class ListViewSearchService {
    
    /**
     * @var BeanManager
     */
    private $beanManager;
//
//    /**
//     * @var AttributeObjectHelper
//     */
//    private $attributeHelper;
//
//    /**
//     * @var RelationshipObjectHelper
//     */
//    private $relationshipHelper;
//
//    /**
//     * @var PaginationObjectHelper
//     */
//    private $paginationHelper;

    /**
     * @param BeanManager $beanManager
     * @param AttributeObjectHelper $attributeHelper
     * @param RelationshipObjectHelper $relationshipHelper
     * @param PaginationObjectHelper $paginationHelper
     */
    public function __construct(
        BeanManager $beanManager//,
//        AttributeObjectHelper $attributeHelper,
//        RelationshipObjectHelper $relationshipHelper,
//        PaginationObjectHelper $paginationHelper
    ) {
        $this->beanManager = $beanManager;
//        $this->attributeHelper = $attributeHelper;
//        $this->relationshipHelper = $relationshipHelper;
//        $this->paginationHelper = $paginationHelper;
    }

    /**
     * @param ListViewSearchParams $params
     *
     * @return JsonSerializable
     */
    public function getListViewSearchDefs(ListViewSearchParams $params)
    {
        $moduleName = $params->getModuleName();
        /** @var SugarBean */
        $bean = \BeanFactory::getBean($moduleName);
        
        $data = ['list', 'view', 'search', 'data', 'example', 'response'];
        
        $response = new AttributeResponse($data);
        return $response;
    }
}
