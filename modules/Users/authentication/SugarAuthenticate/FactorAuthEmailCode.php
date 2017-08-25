<?php

include_once __DIR__ . '/FactorAuthInterface.php';

class FactorAuthEmailCode implements FactorAuthInterface {

    public function showTokenInput()
    {
        global $app_strings;

        $ss = new Sugar_Smarty();

        $theme = SugarThemeRegistry::current();

        $cssPath = $theme->getCSSPath();
        $css = $theme->getCSS();
        $favicon = $theme->getImageURL('sugar_icon.ico',false);

        $ss->assign('APP', $app_strings);
        $ss->assign('cssPath', $cssPath);
        $ss->assign('css', $css);
        $ss->assign('favicon',getJSPath($favicon));

        $ss->display(__DIR__ . '/FactorAuthEmailCode.tpl');
    }
}