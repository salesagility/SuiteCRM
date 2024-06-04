<?php 

/**
* Send notification to employee and the responsible of the employee with the erroneous time tracker record found
* @param
* @param 
* @param 
* @return string
*/

function sendEmailToEmployeeAndResponsible($employee, $row, $info)
{
    global $sugar_config;

    // Get the responsible if exists
    $responsible = null;
    if (!empty($employee->reports_to_name)) {
        $responsible = SticUtils::getRelatedBeanObject($employee, 'reports_to_link');
    }

    // Add employee email to $emailsToSendMessage
    $subject = $info['subject'];       
    $body = $info['body'];
    $body .= ' <a href="' . $sugar_config["site_url"] . '/index.php?module='. $info['module'] .'&return_module=stic_Time_Tracker&action=DetailView&record=' . $row['id'] . '"> ' . $row['name'] . '</a> <br />';
    $body .= $info['errorMsg']; 
    
    if (isset($employee->email1)){
        sendEmail($subject, $body, array($employee->email1));
    }

    if (isset($responsible->email1)) {
        sendEmail($subject, $body, array($responsible->email1));
    }
}

/**
* Send email to recipients
*
* @param String $subject mail subject
* @param String $subject mail body
* @return void
*/
function sendEmail($subject, $body, $recipients)
{
    if (!empty($recipients)) {

        // Prepare mail
        require_once 'include/SugarPHPMailer.php';
        $emailObj = new Email();
        $defaults = $emailObj->getSystemDefaultEmail();

        $mail = new SugarPHPMailer();
        $mail->setMailerForSystem();
        $mail->From = $defaults['email'];
        $mail->FromName = $defaults['name'];

        foreach ($recipients as $address) {
            $mail->addAddress($address);
        }
        
        $mail->Subject = $subject;
        $current_language = $GLOBALS['current_language'];
        $completeHTML = "
        <html lang=\"{$current_language}\">
            <head>
                <title>{$Subject}</title>
            </head>
            <body style=\"font-family: Arial\">
            {$body}
            </body>
        </html>";
        $mail->Body = from_html($completeHTML);
        //$this->saveReport($this->name, $completeHTML);
        $mail->isHtml(true);
        $mail->prepForOutbound();
        $ret = true;
        if (!$ret = $mail->Send()) {
            $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ': There was an error sending the email to the admins.');
        } else {
            $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ': Mail/s sent correctly.');
        }
    }
    return $ret;
}