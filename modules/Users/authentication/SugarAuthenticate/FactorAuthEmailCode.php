<?php


include_once get_custom_file_if_exists('modules/Users/authentication/SugarAuthenticate/FactorAuthInterface.php');
include_once __DIR__ . '/../../../../include/SugarPHPMailer.php';


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

    /**
     * Send a Token Code to User for more factor Authentication,
     * Using selected Email Template on Password Settings page.
     * Template can use $code template variable to formatting Emails.
     * Returns true if success,
     * otherwise false.
     *
     * @param string $token
     * @return bool
     * @throws \phpmailerException
     */
    public function sendToken($token) {
        global $current_user, $sugar_config;

        $ret = true;

        $emailTemplate = new EmailTemplate();
        $emailTemplateId = $sugar_config['passwordsetting']['factoremailtmpl'];
        $emailTemplate->retrieve($emailTemplateId);

        $mailer = new SugarPHPMailer();
        $mailer->setMailerForSystem();

        $emailObj = new Email();
        $defaults = $emailObj->getSystemDefaultEmail();

        $mailer->From = $defaults['email'];
        $mailer->FromName = $defaults['name'];

        $mailer->Subject = from_html($emailTemplate->subject);

        $mailer->Body = from_html($emailTemplate->body_html);
        $mailer->Body_html = from_html($emailTemplate->body_html);
        $mailer->AltBody = from_html($emailTemplate->body);

        $mailer->addAddress($current_user->email1, $current_user->full_name);

        $mailer->replace('code', $token);

        if (!$mailer->send()) {
            $ret = false;
            $GLOBALS['log']->fatal(
                'Email sending for two factor email authentication via Email Code failed. Mailer Error Info: ' .
                $mailer->ErrorInfo
            );
        } else {
            $GLOBALS['log']->debug('FACTOR AUTH: token sent to user: ' .
                $current_user->id . ', token: ' . '{$token}' . ' so we store it in the session'
            );
        }

        return $ret;
    }
}
