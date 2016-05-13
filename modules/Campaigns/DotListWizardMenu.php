<?php

class DotListWizardMenu
{

    private $html;

    public function __construct($mod_strings, $steps, $showLinks = false) {
        $nav_html = '';

        $i = 0;
        if (isset($steps) && !empty($steps)) {
            foreach ($steps as $name => $step) {
                $nav_html .= $this->getWizardMenuItemHTML(++$i, $name, $showLinks ? $step : false);
            }
        }

        $nav_html = $this->getWizardMenuHTML($nav_html);

        $this->html = $nav_html;

    }

    private function getWizardMenuItemHTML($i, $label, $link = false)
    {
        if($i >= 4) {
            parse_str($link, $args);
            if(empty($args['marketing_id'])) {
                $link = false;
            }
        }
//        $label = $link ? ('<a data-link="' . $link . '">' . $label . '</a>')  : ('<a data-link="#">' . $label . '</a>');
//        $html = '<li id="nav_step'.$i.'" onclick="clickLink(this)">'.$label.'</li>';
        $html = '<li id="nav_step'.$i.'" class="nav-steps" data-nav-step="'.$i.'"  onclick="gotoWizardStep(this)"><div>'.$label.'</div></li>';
        return $html;
    }

    private function getWizardMenuHTML($innerHTML)
    {
        $html = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'tpls'.DIRECTORY_SEPARATOR.'progressStepsStyle.html');
        $html .=
'<div class="progression-container">
    <ul class="progression">
    '.$innerHTML.'
    </ul>
</div>';
        return $html;
    }

    public function __toString()
    {
        return $this->html;
    }

}
