<?php

class EmailTemplateParser
{
    /**
     * Official expression for variables, extended with underscore
     * @see http://php.net/manual/en/language.variables.basics.php
     */
    const PATTERN = '/\$([a-zA-Z_\x7f-\xff]+_[a-zA-Z0-9_\x7f-\xff]*)/';

    /**
     * Allowed keys as result
     */
    const ALLOWED_ATTRIBUTES = ['subject', 'body_html', 'body'];

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

        foreach (static::ALLOWED_ATTRIBUTES as $key) {
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
