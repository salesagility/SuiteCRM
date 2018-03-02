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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class EmailTemplateParser
{
    /**
     * Official expression for variables, extended with underscore
     * @see http://php.net/manual/en/language.variables.basics.php
     */
    const PATTERN = '/\$([a-zA-Z_\x7f-\xff]+_[a-zA-Z0-9_\x7f-\xff]*)/';

    /**
     * Allowed keys as result
     * @var array
     */
    private static $allowedAttributes = ['subject', 'body_html', 'body'];

    /**
     * @var EmailTemplate
     */
    private $template;

    /**
     * @var Campaign
     */
    private $campaign;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Surveys
     */
    private $survey;

    /**
     * @param EmailTemplate $template
     * @param Campaign $campaign
     * @param User $user
     */
    public function __construct(EmailTemplate $template, Campaign $campaign, User $user)
    {
        $this->template = $template;
        $this->campaign = $campaign;
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function parseVariables()
    {
        $templateData = [];

        foreach (static::$allowedAttributes as $key) {
            if (property_exists($this->template, $key)) {
                $templateData[$key] = $this->getParsedValue($this->template->$key);
            }
        }

        return $templateData;
    }

    /**
     * @param string $attributeValue
     *
     * @return string
     */
    private function getParsedValue($attributeValue)
    {
        $matches = preg_match_all(static::PATTERN, $attributeValue, $variables);

        if ($matches !== 0) {
            foreach ($variables[0] as $variable) {
                $attributeValue = str_replace($variable, $this->getValueFromBean($variable), $attributeValue);
            }
        }

        return $attributeValue;
    }

    /**
     * This is need to be extended properly and replace the method below in the future
     * @see EmailTemplate::parse_email_template
     *
     * @param string $variable
     *
     * @return string
     */
    private function getValueFromBean($variable)
    {
        $reference = null;
        $parts = explode('_', ltrim($variable, '$'));
        list($moduleName, $attribute) = [array_shift($parts), join('_', $parts)];

        switch ($moduleName) {
            case 'surveys':
                $reference = $this->getSurvey();
                break;
            case 'contact':
                $reference = $this->user;
                break;
            default:
                $GLOBALS['log']->warn(sprintf('Invalid bean when parsing (%s)', $moduleName));
                return $variable;
        }

        if (isset($reference->$attribute)) {
            return $reference->$attribute;
        }

        $GLOBALS['log']->warn(
            sprintf('%s does not set in %s bean', $attribute, $moduleName)
        );

        return $variable;
    }

    /**
     * @return Surveys
     */
    public function getSurvey()
    {
        if ($this->survey === null) {
            $this->survey = BeanFactory::getBean('Surveys', $this->campaign->survey_id);
        }

        return $this->survey;
    }
}
