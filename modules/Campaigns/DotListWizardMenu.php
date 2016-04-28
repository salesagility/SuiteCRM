<?php

class DotListWizardMenu
{

    private $html;

    public function DotListWizardMenu(){
        self::__construct();
    }


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
        if($i>=4) {
            parse_str($link, $args);
            if(empty($args['marketing_id'])) {
                $link = false;
            }
        }
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
.wizmenu * {margin: 0; padding: 0; border: none; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 9.9px; font-weight: bold; line-height: 9.9px;}
.wizmenu ul {display: block; float: none; list-style-type: none; margin: 0; padding: 0;}
.wizmenu ul li {position: relative; background-image: url({$imgdir}center-empty.png); background-repeat: no-repeat; display: block; float: left; width: 90px; height: 35px; list-style-type: none; margin: 0; padding: 40px 0 0 0; text-align: center;}
.wizmenu ul li:first-child {background-image: url({$imgdir}left-start.png);}
.wizmenu ul li:last-child {background-image: url({$imgdir}right-empty.png);}
.wizmenu.tiny ul li {margin-right: -33px}
.wizmenu .label {color: gray;}
.wizmenu a .label {color: #337ab7; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 9.9px; font-weight: bold; line-height: 9.9px;}
.wizmenu a:hover .label {color: #136aa7;}
.wizmenu .clear {clear: both;}
.wizmenu .dot {display: block; float: none; position: absolute; top: 1px; left: 0; width: 90px; height: 35px; background-image: url({$imgdir}dot.png);}

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
            $(e).next().css('background-image', 'url({$imgdir}center-full-half.png)');
        }
        else if(i > 0 && i < $('.wizmenu ul li').length-2 && $(e).find('a').length && $(e).next().find('a').length) {
            $(e).css('background-image', 'url({$imgdir}center-full.png)');
            $(e).next().css('background-image', 'url({$imgdir}center-full-half.png)');
        }
        else if(i > 0 && $(e).find('a').length && $(e).next().find('a').length) {
            $(e).css('background-image', 'url({$imgdir}center-full.png)');
            $(e).next().css('background-image', 'url({$imgdir}right-full.png)');
        }
    });
};

var wizardMenuCleanupAlreadyFinishedStep = function() {
    var doAgain = false;
    $('.wizmenu ul li').each(function(i,e){
        if(!$(e).find('a').length) {
            if($(e).next().find('a').length) {
                $(e).html('<a href="#">' + $(e).html() + '</a>');
                doAgain = true;
            }
        }
    });
    if(doAgain) {
        wizardMenuCleanupAlreadyFinishedStep();
    }
};

var wizardMenuCleanup = function() {
    $('.wizmenu ul li a').each(function(i,e){
        if(!$(e).html()) {
            $(e).addClass('removable');
        }
    });
    $('.wizmenu ul li a.removable').remove();

    wizardMenuCleanupAlreadyFinishedStep();
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

var wizardMenuFillAll = function() {
    $('.wizmenu ul li').each(function(i,e){
        if(!$(e).find('a').length) {
            $(e).prepend('<a href="#">&nbsp;</a>');
        }
    });
};

var wizardMenuSetStepLink = function(step, link, script) {
    if(typeof link == 'undefined') {
        link = '#';
    }
    if(typeof script == 'undefined') {
        var onClick = false;
    }
    else {
        var onClick = ' onclick="' + script + '"';
    }
    if($('#nav_step' + step + ' a').length == 0) {
        $('#nav_step' + step).html('<a href="' + link + '"' + (onClick ? onClick : '') + '>' + $('#nav_step' + step).html() + '</a>');
    }
    else {
        $('#nav_step' + step + ' a').attr('href', link);
        if(onClick) {
            $('#nav_step' + step + ' a').attr('onclick', script);
        }
    }
};

var wizardMenuGetCurrentPage = function() {
    var campaignType = getParameterByName('campaign_type') ? getParameterByName('campaign_type') : (document.getElementById('campaign_type') ? document.getElementById('campaign_type').value : null);
    var step1Shows = $('#step1').css('display') && $('#step1').css('display') != 'none'; // Campaign Header OR!! Email Templates
    var step2Shows = $('#step2').css('display') && $('#step2').css('display') != 'none'; // Subscriptions / Target Lists / Budget OR!! Marketing
    var step3Shows = $('#step3').css('display') && $('#step3').css('display') != 'none'; // Target Lists / Summary

    var step;

    if(campaignType == 'NewsLetter' || campaignType == 'Email' || campaignType == null) {
        if(step1Shows) {
            if(typeof step3Shows == 'undefined') {
                step = 1;
            }
            else {
                step = 3;
            }
        }
        else if(step2Shows) {
            if(typeof step3Shows == 'undefined') {
                step = 2;
            }
            else {
                step = 4;
            }
        }
        else if(step3Shows) {
            step = 5;
        }
        else {
            console.log('unknown page - 1');
        }
    }
    else if(campaignType == 'Telesales') {
        if(step1Shows) {
            step = 1;
        }
        else if(step2Shows) {
            step = 2;
        }
        else if(step3Shows) {
            if($('#step3').attr('data') == 'summary-page') {
                step = 4;
            }
            else {
                step = 3;
            }
        }
        else {
            console.log('unknown page - 2');
        }
    }
    else {
        console.log('unknown page - 3');
    }

    return step-1;
};

var getBGImageName = function(elem) {
    var bgImage = $(elem).css('background-image').split('/');
    bgImage = bgImage[bgImage.length-1].split('.')[0];
    return bgImage;
};

var wizardMenuPutDotToCurrentPage = function() {
    var page = wizardMenuGetCurrentPage();
    var link = '#';
    if(page != '2') {
        wizardMenuSetStepLink(page+1, link);
    }
    $('.wizmenu li').each(function(i,e){
        if(i==page) {
            var bgImage = getBGImageName(e);
            if(!$(e).find('.dot').length) {
                $(e).append('<span class="dot"></span>');
            }
        }
        else {
            $(e).find('.dot').remove();
        }
    });
};

var wizardMenu = function() {
    wizardMenuCleanup();
    wizardMenuCenter();
    wizardMenuSetToCurrentStep();
    wizardMenuResetWidth();
    wizardMenuPutDotToCurrentPage();
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
