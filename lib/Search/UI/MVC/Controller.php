<?php
/**
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

namespace SuiteCRM\Search\UI\MVC;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * Generic controller for the Search Framework.
 */
abstract class Controller
{
    /** @var View */
    protected $view;

    /**
     * Controller constructor.
     *
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * Handles a request by reading the request 'do' parameters.
     *
     * Always falls back to the 'display' method.
     */
    public function handle()
    {
        if ($this->isActionRequest()) {
            $methodName = $this->getActionName();
            $this->$methodName();
            return;
        }

        $this->display();
    }

    /**
     * Echoes the view.
     */
    public function display()
    {
        $this->view->preDisplay();
        $this->view->display();
    }

    /**
     * Performs a redirect to a page.
     *
     * @param string $location
     */
    public function redirect($location)
    {
        header("Location: $location");
        exit;
    }

    /**
     * Returns true if the current request has been sent via AJAX.
     *
     * @return bool
     */
    public function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * Echoes a JSON with the proper header parameters.
     *
     * @param array $data
     */
    public function yieldJson(array $data)
    {
        ob_clean(); // deletes the rest of the html previous to this.
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Returns whether the client is asking for an action to be executed by the controller.
     *
     * @return bool
     */
    private function isActionRequest()
    {
        return method_exists($this, $this->getActionName());
    }

    /**
     * Returns the name of the action sent by the client, sanitized and prefixed with 'do'.
     *
     * @return string
     */
    private function getActionName()
    {
        return 'do' . filter_input(INPUT_GET, 'do', FILTER_SANITIZE_STRING);
    }
}
