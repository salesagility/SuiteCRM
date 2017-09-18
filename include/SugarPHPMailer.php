<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'include/phpmailer/class.phpmailer.php';
require_once 'include/phpmailer/class.smtp.php';
require_once 'include/OutboundEmail/OutboundEmail.php';

/**
 * Sugar mailer
 * @api
 */
class SugarPHPMailer extends PHPMailer
{
    /*
     * var OutboundEmail
     */
    public $oe;
    public $protocol = 'tcp://';
    public $preppedForOutbound = false;
    public $disclosureEnabled;
    public $disclosureText;
    public $isHostEmpty = false;
    public $opensslOpened = true;

    /**
     * Sole constructor
     */
    public function __construct()
    {
        parent::__construct();
        global $locale;
        global $current_user;
        global $sugar_config;

        $admin = new Administration();
        $admin->retrieveSettings();

        if (isset($admin->settings['disclosure_enable']) && !empty($admin->settings['disclosure_enable'])) {
            $this->disclosureEnabled = true;
            $this->disclosureText = $admin->settings['disclosure_text'];
        }

        $this->oe = new OutboundEmail();
        $this->oe->getUserMailerSettings($current_user);

        $this->setLanguage('en', 'include/phpmailer/language/');
        $this->PluginDir = 'include/phpmailer/';
        $this->Mailer = 'smtp';
        // cn: i18n
        $this->CharSet = $locale->getPrecedentPreference('default_email_charset');
        $this->Encoding = 'quoted-printable';
        $this->isHTML(false);  // default to plain-text email
        $this->Hostname = $sugar_config['host_name'];
        $this->WordWrap = 996;
        // cn: gmail fix
        $this->protocol = ($this->oe->mail_smtpssl == 1) ? 'ssl://' : $this->protocol;
        $this->SMTPAutoTLS = false;

    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8,
     *     please update your code, use __construct instead
     */
    public function SugarPHPMailer()
    {
        $deprecatedMessage =
            'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }

    /**
     * Prefills outbound details
     */
    public function setMailer()
    {
        global $current_user;

        require_once 'include/OutboundEmail/OutboundEmail.php';
        $oe = new OutboundEmail();
        $oe = $oe->getUserMailerSettings($current_user);

        // ssl or tcp - keeping outside isSMTP b/c a default may inadvertently set ssl://
        $this->protocol = $oe->mail_smtpssl ? 'ssl://' : 'tcp://';

        if ($oe->mail_sendtype === 'SMTP') {
            //Set mail send type information
            $this->Mailer = 'smtp';
            $this->Host = $oe->mail_smtpserver;
            $this->Port = $oe->mail_smtpport;
            if ($oe->mail_smtpssl == 1) {
                $this->SMTPSecure = 'ssl';
            } // if
            if ($oe->mail_smtpssl == 2) {
                $this->SMTPSecure = 'tls';
            } // if

            if ($oe->mail_smtpauth_req) {
                $this->SMTPAuth = true;
                $this->Username = $oe->mail_smtpuser;
                $this->Password = $oe->mail_smtppass;
            }
        } else {
            $this->Mailer = 'sendmail';
        }
    }

    /**
     * Prefills mailer for system
     */
    public function setMailerForSystem()
    {
        require_once 'include/OutboundEmail/OutboundEmail.php';
        $oe = new OutboundEmail();
        $oe = $oe->getSystemMailerSettings();

        // ssl or tcp - keeping outside isSMTP b/c a default may inadvertantly set ssl://
        $this->protocol = $oe->mail_smtpssl ? 'ssl://' : 'tcp://';

        if ($oe->mail_sendtype === 'SMTP') {
            //Set mail send type information
            $this->Mailer = 'smtp';
            $this->Host = $oe->mail_smtpserver;
            $this->Port = $oe->mail_smtpport;
            if ($oe->mail_smtpssl == 1) {
                $this->SMTPSecure = 'ssl';
            } // if
            if ($oe->mail_smtpssl == 2) {
                $this->SMTPSecure = 'tls';
            } // if
            if ($oe->mail_smtpauth_req) {
                $this->SMTPAuth = true;
                $this->Username = $oe->mail_smtpuser;
                $this->Password = $oe->mail_smtppass;
            }
        } else {
            $this->Mailer = 'sendmail';
        }
    }

    /**
     * handles Charset translation for all visual parts of the email.
     */
    public function prepForOutbound()
    {
        global $locale;

        if (!$this->preppedForOutbound) {
            //bug 28534. We should not set it to true to circumvent the following conversion as each email is independent.
            //$this->preppedForOutbound = true; // flag so we don't redo this
            $OBCharset = $locale->getPrecedentPreference('default_email_charset');

            // handle disclosure
            if ($this->disclosureEnabled) {
                $this->Body .= "<br />&nbsp;<br />{$this->disclosureText}";
                $this->AltBody .= "\r\r{$this->disclosureText}";
            }

            // body text
            $this->Body = from_html($locale->translateCharset(trim($this->Body), 'UTF-8', $OBCharset));
            $this->AltBody = from_html($locale->translateCharset(trim($this->AltBody), 'UTF-8', $OBCharset));
            $subjectUTF8 = from_html(trim($this->Subject));
            $subject = $locale->translateCharset($subjectUTF8, 'UTF-8', $OBCharset);
            $this->Subject = $locale->translateCharset($subjectUTF8, 'UTF-8', $OBCharset);

            // HTML email RFC compliance
            if ($this->ContentType === 'text/html' && strpos($this->Body, '<html') === false) {

                $langHeader = get_language_header();

                $head = <<<eoq
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" {$langHeader}>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset={$OBCharset}" />
<title>{$subject}</title>
</head>
<body>
eoq;
                $this->Body = $head . $this->Body . '</body></html>';
            }

            $this->FromName = $locale->translateCharset(trim($this->FromName), 'UTF-8', $OBCharset);

        }
    }

    /**
     * Replace images with locations specified by regex with cid: images
     * and attach needed files
     *
     * @param string $regex Regular expression
     * @param string $local_prefix Prefix where local files are stored
     * @param bool $object Use attachment object
     */
    public function replaceImageByRegex($regex, $local_prefix, $object = false)
    {
        preg_match_all("#<img[^>]*[\s]+src[^=]*=[\s]*[\"']($regex)(.+?)[\"']#si", $this->Body, $matches);
        $i = 0;
        foreach ($matches[2] as $match) {
            $filename = urldecode($match);
            $cid = $filename;
            $file_location = $local_prefix . $filename;
            if (!file_exists($file_location)) {
                continue;
            }
            if ($object) {
                if (preg_match('#&(?:amp;)?type=([\w]+)#i', $matches[0][$i], $typematch)) {
                    switch (strtolower($typematch[1])) {
                        case 'documents':
                            $beanname = 'DocumentRevisions';
                            break;
                        case 'notes':
                            $beanname = 'Notes';
                            break;
                    }
                }
                $mime_type = 'application/octet-stream';
                if (isset($beanname)) {
                    $bean = BeanFactory::getBean($beanname, $filename);
                    if (!empty($bean->id)) {
                        $mime_type = $bean->file_mime_type;
                        $filename = $bean->filename;
                    }
                }
            } else {
                $mime_type = 'image/' . strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            }
            if (!$this->embeddedAttachmentExists($cid)) {
                $this->addEmbeddedImage($file_location, $cid, $filename, 'base64', $mime_type);
            }
            $i++;
        }
        //replace references to cache with cid tag
        $this->Body = preg_replace("|\"$regex|i", '"cid:', $this->Body);
        // remove bad img line from outbound email
        $this->Body = preg_replace('#<img[^>]+src[^=]*=\"\/([^>]*?[^>]*)>#sim', '', $this->Body);
    }

    /**
     * @param array $notes
     *
     * @throws \phpmailerException
     */
    public function handleAttachments($notes)
    {
        global $sugar_config;

        // cn: bug 4864 - reusing same SugarPHPMailer class, need to clear attachments
        $this->clearAttachments();

        //replace references to cache/images with cid tag
        $this->Body = preg_replace(';=\s*"' . preg_quote(sugar_cached('images/'), ';') . ';', '="cid:', $this->Body);

        $this->replaceImageByRegex("(?:{$sugar_config['site_url']})?/?cache/images/", sugar_cached('images/'));

        //Replace any embeded images using the secure entryPoint for src url.
        $this->replaceImageByRegex(
            "(?:{$sugar_config['site_url']})?index.php[?]entryPoint=download&(?:amp;)?[^\"]+?id=",
            'upload://',
            true
        );

        if (empty($notes)) {
            return;
        }
        //Handle regular attachments.
        foreach ($notes as $note) {
            $mime_type = 'text/plain';
            $file_location = '';
            $filename = '';

            if ($note->object_name === 'Note') {
                if (!empty($note->file->temp_file_location) && is_file($note->file->temp_file_location)) {
                    $file_location = $note->file->temp_file_location;
                    $filename = $note->file->original_file_name;
                    $mime_type = $note->file->mime_type;
                } else {
                    $file_location = "upload://{$note->id}";
                    $filename = $note->id . $note->filename;
                    $mime_type = $note->file_mime_type;
                }
            } elseif ($note->object_name === 'DocumentRevision') { // from Documents
                $filename = $note->id . $note->filename;
                $file_location = "upload://$filename";
                $mime_type = $note->file_mime_type;
            }

            $filename =
                substr($filename, 36, strlen($filename)); // strip GUID	for PHPMailer class to name outbound file
            if (!$note->embed_flag) {
                $this->addAttachment($file_location, $filename, 'base64', $mime_type);
            } // else
        }
    }

    /**
     * overloads class.phpmailer's setError() method so that we can log errors in sugarcrm.log
     *
     * @param string $msg
     */
    protected function setError($msg)
    {
        $GLOBALS['log']->fatal("SugarPHPMailer encountered an error: {$msg}");
        parent::setError($msg);
    }

    /**
     * @param array $options
     *
     * @return bool
     * @throws \phpmailerException
     */
    public function smtpConnect($options = array())
    {
        $connection = parent::smtpConnect();
        if (!$connection) {
            global $app_strings;
            if (isset($this->oe) && $this->oe->type === 'system') {
                $this->setError($app_strings['LBL_EMAIL_INVALID_SYSTEM_OUTBOUND']);
            } else {
                $this->setError($app_strings['LBL_EMAIL_INVALID_PERSONAL_OUTBOUND']);
            } // else
        }

        return $connection;
    } // fn

    /**
     * overloads PHPMailer::PreSend() to allow for empty messages to go out.
     *
     * @return bool
     * @throws \phpmailerException
     */
    public function PreSend()
    {
        //check to see if message body is empty
        if (empty($this->Body)) {
            //PHPMailer will throw an error if the body is empty, so insert a blank space if body is empty
            $this->Body = ' ';
        }

        return parent::preSend();
    }

    /**
     * Checks if the embedded file is already attached.
     *
     * @param string $filename Name of the file to check.
     *
     * @return boolean
     */
    protected function embeddedAttachmentExists($filename)
    {
        foreach ($this->attachment as $attachment) {
            if ($attachment[1] === $filename) {
                return true;
            }
        }

        return false;
    }

} // end class definition
