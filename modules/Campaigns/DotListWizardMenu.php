<?php

class DotListWizardMenu
{

    private $html;

    public function __construct($mod_strings, $steps,$type,$mrkt_string,$summ_url) {
        $nav_html = '';

        $i = 0;
        if (isset($steps) && !empty($steps)) {
            foreach ($steps as $name => $step) {
                $i++;
                $nav_html .= $this->getWizardMenuItemHTML($i, $name);
            }
        }

        if ($type == 'newsletter' || $type == 'email') {
            $nav_html .= $this->getWizardMenuItemHTML($i + 1, $mrkt_string);
            $nav_html .= $this->getWizardMenuItemHTML($i + 2, $mod_strings['LBL_NAVIGATION_MENU_SEND_EMAIL']);
            $nav_html .= $this->getWizardMenuItemHTML($i + 3, $summ_url);
        } else {
            $nav_html .= $this->getWizardMenuItemHTML($i + 1, $summ_url);
        }

        $nav_html = $this->getWizardMenuHTML($nav_html);

        $this->html = $nav_html;

    }

    private function getWizardMenuItemHTML($i, $name)
    {
        $html = <<<HTML
<li class="step" id="nav_step$i">
    <span class="label">$name</span>
</li>
HTML;
        return $html;
    }

    private function getWizardMenuHTML($innerHTML)
    {
        $imgdir =  'themes/SuiteR/images/wizmenu/';

        $html = <<<HTML
<style>
.wizmenu * {margin: 0; padding: 0; border: none;}
.wizmenu ul {display: block; float: none; list-style-type: none; margin: 0; padding: 0;}
.wizmenu ul li {background-image: url({$imgdir}center-empty.png); background-repeat: no-repeat; display: block; float: left; width: 90px; height: 35px; list-style-type: none; margin: 0; padding: 40px 0 0 0; text-align: center;}
.wizmenu ul li:first-child {background-image: url({$imgdir}left-start.png);}
.wizmenu ul li:last-child {background-image: url({$imgdir}right-empty.png);}
.wizmenu .label {color: gray;}
.wizmenu .clear {clear: both;}

</style>
<div class="wizmenu">
    <ul>$innerHTML</ul>
    <div class="clear"></div>
</div>
HTML;
        return $html;
    }

    public function __toString()
    {
        return $this->html;
    }

}
