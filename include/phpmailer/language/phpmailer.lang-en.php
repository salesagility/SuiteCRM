<?php

/*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r51719 - 2009-10-22 10:18:00 -0700 (Thu, 22 Oct 2009) - mitani - Converted to Build 3  tags and updated the build system 

r51634 - 2009-10-19 13:32:22 -0700 (Mon, 19 Oct 2009) - mitani - Windex is the branch for Sugar Sales 1.0 development

r50375 - 2009-08-24 18:07:43 -0700 (Mon, 24 Aug 2009) - dwong - branch kobe2 from tokyo r50372

r43691 - 2009-01-29 15:25:53 -0800 (Thu, 29 Jan 2009) - faissah - 27521  : Update to phpmailer version 2.3.

r42807 - 2008-12-29 11:16:59 -0800 (Mon, 29 Dec 2008) - dwong - Branch from trunk/sugarcrm r42806 to branches/tokyo/sugarcrm

r11652 - 2006-02-21 18:24:06 -0800 (Tue, 21 Feb 2006) - chris - Bug 4719: updating PHPMailer classes for security (DDoS)
Touched:
include/phpmailer (everything)
include/SugarPHPMailer.php (adding our constructor)
modules/Email/Email.php (to use the new constructor)

r915 - 2004-10-08 15:31:10 -0700 (Fri, 08 Oct 2004) - julian - E-mail notification feature + new admin console


*/


/**
 * PHPMailer language file.
 * English Version
 */

$PHPMAILER_LANG = array();

$PHPMAILER_LANG["provide_address"]      = 'You must provide at least one ' .
                                          'recipient email address.';
$PHPMAILER_LANG["mailer_not_supported"] = ' mailer is not supported.';
$PHPMAILER_LANG["execute"]              = 'Could not execute: ';
$PHPMAILER_LANG["instantiate"]          = 'Could not instantiate mail function.';
$PHPMAILER_LANG["authenticate"]         = 'SMTP Error: Could not authenticate.';
$PHPMAILER_LANG["from_failed"]          = 'The following From address failed: ';
$PHPMAILER_LANG["recipients_failed"]    = 'SMTP Error: The following ' .
                                          'recipients failed: ';
$PHPMAILER_LANG["data_not_accepted"]    = 'SMTP Error: Data not accepted.';
$PHPMAILER_LANG["connect_host"]         = 'SMTP Error: Could not connect to SMTP host.';
$PHPMAILER_LANG["file_access"]          = 'Could not access file: ';
$PHPMAILER_LANG["file_open"]            = 'File Error: Could not open file: ';
$PHPMAILER_LANG["encoding"]             = 'Unknown encoding: ';
$PHPMAILER_LANG["signing"]              = 'Signing Error: ';

?>
