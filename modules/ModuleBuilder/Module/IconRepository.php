<?php

class IconRepository
{
    const DEFAULT_ICON = 'default';
    const ICON_LABELS = 'labels';
    const ICON_FIELDS = 'fields';
    const ICON_RELATIONSHIPS = 'relationships';
    const ICON_LAYOUTS = 'layouts';
    const ICON_SUBPANELS = 'labels';

    /**
     * @var array
     */
    private static $iconNames = [
        AOS_Contracts::class => 'aos-contracts-signature',
        'EmailTemplates' => 'emails',
        'Employees' => 'users',
        jjwg_Address_Cache::class => 'jjwg-markers',
        'ProjectTask' => 'am-tasktemplates',
        AM_ProjectTemplates::class => 'am-tasktemplates',
        'SurveyQuestionOptions' => self::DEFAULT_ICON,
        'SurveyQuestionResponses' =>  self::DEFAULT_ICON,
        'SurveyQuestions' => self::DEFAULT_ICON,
        'SurveyResponses' => 'survey-responses',
        'Prospects' => 'targets'
    ];

    /**
     * @param string $module
     *
     * @return string
     */
    public static function getIconName($module)
    {
        return isset(static::$iconNames[$module])
            ? static::$iconNames[$module]
            : strtolower(str_replace('_', '-', $module));
    }
}
