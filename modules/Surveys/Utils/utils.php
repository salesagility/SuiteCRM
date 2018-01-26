<?php
function survey_url_display(Surveys $survey)
{
    if ($survey->status != 'Public') {
        return '';
    }
    global $sugar_config;
    $url = $sugar_config['site_url'] . "/index.php?entryPoint=survey&id=" . $survey->id;

    return "<a href='$url'>$url</a>";
}

/**
 * @param Surveys $survey
 * @param string $name
 * @param string $value
 * @param string $view
 * @return string
 * @todo need to implement? defined at modules/Surveys/vardefs.php:105
 */
function happiness_question_display(Surveys $survey, $name, $value, $view) {
    $ret = '';
    return $ret;
}