<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

namespace SuiteCRM\API\JsonApi\v1\Filters\Interpreters;

use SuiteCRM\API\JsonApi\v1\Filters\Interpreters\ByIdFilters\ByIdFilter;
use SuiteCRM\API\JsonApi\v1\Filters\Validators\FieldValidator;
use SuiteCRM\Exception\Exception;

use Psr\Container\ContainerInterface;

class FilterInterpreter
{
    /**
     * @var ContainerInterface $containers
     */
    private $containers;

    public function __construct(ContainerInterface $containers)
    {
        $this->containers = $containers;
    }

    public function isFilterByPreMadeName($filterStructure) {
        if(is_array($filterStructure) === false) {
            throw new Exception('[JsonApi][v1][Filters][Interpreters][isFilterByPreMadeName][expected type to be array]');
        }

        return count($filterStructure) === 1 && is_array(current($filterStructure)) === false;
    }

    public function isFilterById($filterStructure) {
        if(is_array($filterStructure) === false) {
            throw new Exception('[JsonApi][v1][Filters][Interpreters][isFilterById][expected type to be array]');
        }

        return count($filterStructure) === 1 &&
            array_keys($filterStructure)[0] === '[id]' &&
            is_array(current($filterStructure)) === true;
    }

    public function isFilterByAttributes($filterStructure) {
        if(is_array($filterStructure) === false) {
            throw new Exception('[JsonApi][v1][Filters][Interpreters][isFilterByAttributes][expected type to be array]');
        }

        $fieldValidator = new FieldValidator();
        return count($filterStructure) >= 1 &&
            is_array(current($filterStructure)) === true &&
            array_keys($filterStructure)[0] !== '[id]' &&
        $fieldValidator->isValid(array_keys($filterStructure)[0]);
    }

    public function getFilterByPreMadeName($filterStructure)
    {
        $filter = '';
        $filterName = current($filterStructure);
        $interpreters = $this->containers->get('ByPreMadeFilterInterpreters');

        /** @var  \SuiteCRM\API\JsonApi\v1\Filters\Interfaces\ByPreMadeFilterInterpreter $interpreter */
        foreach ($interpreters as $interpreter) {
            if($interpreter->hasByPreMadeFilter($filterName)) {
                $filter = $interpreter->getByPreMadeFilter();
            }
        }

        if(empty($filter)) {
            throw new Exception('[JsonApi][v1][Filters][Interpreters][getFilterByPreMadeName][cannot find filter]');
        }

        return $filter;
    }

    public function getFilterById($filterStructure)
    {
        $filter = '';
        /** @var ByIdFilter $filter */
        $interpreter = $this->containers->get('ByIdFilterInterpreter');
        $filter = $interpreter->getByIdFilter($filterStructure);

        if(empty($filter)) {
            if(is_array($filterStructure) === false) {
                throw new Exception('[JsonApi][v1][Filters][Interpreters][getFilterById][cannot find filter]');
            }
        }

        return $filter;
    }

    public function getFilterByAttributes($filterStructure)
    {

    }
}