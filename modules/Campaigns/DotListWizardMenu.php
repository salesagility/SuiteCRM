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
        $label = $link ? ('<a href="' . $link . '">' . $label . '</a>')  : $label;
        $html = <<<HTML
<li class="step" id="nav_step$i">
    <span class="label">$label</span>
</li>
HTML;
        return $html;
    }

    private function getWizardMenuHTML($innerHTML)
    {
        $imgdir =  'themes/SuiteR/images/wizmenu/';

        $html = <<<HTML
<style>
.wizmenu {float: left; height: 80px;}
.wizmenu * {margin: 0; padding: 0; border: none;}
.wizmenu ul {display: block; float: none; list-style-type: none; margin: 0; padding: 0;}
.wizmenu ul li {background-image: url({$imgdir}center-empty.png); background-repeat: no-repeat; display: block; float: left; width: 90px; height: 35px; list-style-type: none; margin: 0; padding: 40px 0 0 0; text-align: center;}
.wizmenu ul li:first-child {background-image: url({$imgdir}left-start.png);}
.wizmenu ul li:last-child {background-image: url({$imgdir}right-empty.png);}
.wizmenu.tiny ul li {margin-right: -33px}
.wizmenu .label {color: gray;}
.wizmenu .clear {clear: both;}

</style>
<div class="wizmenu">
    <ul>$innerHTML</ul>
    <div class="clear"></div>
</div>
<script type="text/javascript">

var wizardMenuCenter = function() {
    // set navbar to center of page..
    $('.wizmenu').css('margin-left', ($('.wizmenu').parent().outerWidth() - $('.wizmenu').outerWidth()) / 2);
};

var wizardMenuSetToCurrentStep = function() {
    // fill navbar to current step
    $('.wizmenu ul li').each(function(i,e){
        if(i==0 && $(e).find('a').length && $(e).next().find('a').length) {
            $(e).css('background-image', 'url({$imgdir}left-full.png)');
            $(e).next().css('background-image', 'url({$imgdir}center-active.png)');
        }
        else if(i > 0 && i < $('.wizmenu ul li').length-2 && $(e).find('a').length && $(e).next().find('a').length) {
            $(e).css('background-image', 'url({$imgdir}center-full.png)');
            $(e).next().css('background-image', 'url({$imgdir}center-active.png)');
        }
        else if(i > 0 && $(e).find('a').length && $(e).next().find('a').length) {
            $(e).css('background-image', 'url({$imgdir}center-full.png)');
            $(e).next().css('background-image', 'url({$imgdir}right-full.png)');
        }
    });
};

var wizardMenuCleanup = function() {
    $('.wizmenu ul li a').each(function(i,e){
        if(!$(e).html()) {
            $(e).addClass('removable');
        }
    });
    $('.wizmenu ul li a.removable').remove();
}

var wizardMenuResetWidth = function() {
    var sum = 0;
    $('.wizmenu ul li').each(function(i,e){
        sum += $(e).outerWidth(true);
    });
    if(sum >= $('.wizmenu').parent().outerWidth(true)) {
        $('.wizmenu').addClass('tiny');
    }
    else {
        if(sum + $('.wizmenu ul li').length*33 < $('.wizmenu').parent().outerWidth(true)) {
            $('.wizmenu').removeClass('tiny');
        }
    }
};

var wizardMenu = function() {
    wizardMenuCleanup();
    wizardMenuCenter();
    wizardMenuSetToCurrentStep();
    wizardMenuResetWidth();
};

$(function(){

    wizardMenu();

    $(window).resize(function(){
        wizardMenu();
    });

    setInterval(function(){
        wizardMenu();
    }, 300);
});
</script>
HTML;
        return $html;
    }

    public function __toString()
    {
        return $this->html;
    }

}
