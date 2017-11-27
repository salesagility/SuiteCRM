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
