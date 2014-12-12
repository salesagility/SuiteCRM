<?php
 /**
 * 
 * 
 * @package 
 * @copyright SalesAgility Ltd http://www.salesagility.com
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */
$job_strings[] = 'aorRunScheduledReports';

function aorRunScheduledReports(){
    require_once 'include/SugarQueue/SugarJobQueue.php';
    $date = new DateTime();//Ensure we check all schedules at the same instant
    foreach(BeanFactory::getBean('AOR_Scheduled_Reports')->get_full_list() as $scheduledReport){

        if($scheduledReport->shouldRun($date)){
            if(empty($scheduledReport->aor_report_id)){
                continue;
            }
            $job = new SchedulersJob();
            $job->name = "Scheduled report - {$scheduledReport->name} on {$date->format('c')}";
            $job->data = $scheduledReport->id;
            $job->target = "class::AORScheduledReportJob";
            $job->assigned_user_id = 1;
            $jq = new SugarJobQueue();
            $jobid = $jq->submitJob($job);
        }
    }
}



class AORScheduledReportJob implements RunnableSchedulerJob
{
    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }
    public function run($data)
    {
        global $sugar_config, $timedate;

        $bean = BeanFactory::getBean('AOR_Scheduled_Reports',$data);
        $report = $bean->get_linked_beans('aor_report','AOR_Reports');
        if($report){
            $report = $report[0];
        }else{
            return false;
        }
        $html = "<h1>{$report->name}</h1>".$report->build_group_report();
        $html .= <<<EOF
        <style>
        h1{
            color: {$sugar_config['colourselector']['pageheader']};
        }
        .list
        {
            font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;
            background: #fff;margin: 45px;width: 480px;border-collapse: collapse;text-align: left;
        }
        .list th
        {
            font-size: 14px;
            font-weight: normal;
            color: {$sugar_config['colourselector']['pageheader']};
            padding: 10px 8px;
            border-bottom: 2px solid {$sugar_config['colourselector']['menubrd']};
        }
        .list td
        {
            padding: 9px 8px 0px 8px;
        }
        </style>
EOF;
        $emailObj = new Email();
        $defaults = $emailObj->getSystemDefaultEmail();
        $mail = new SugarPHPMailer();
        $mail->setMailerForSystem();
        $mail->IsHTML(true);
        $mail->From = $defaults['email'];
        $mail->FromName = $defaults['name'];
        $mail->Subject=from_html($bean->name);
        $mail->Body=$html;
        $mail->prepForOutbound();
        $success = true;
        $emails = $bean->get_linked_beans('email_addresses','EmailAddresses');
        foreach($emails as $email) {
            if($email->invalid_email){
                continue;
            }
            $mail->ClearAddresses();
            $mail->AddAddress($email->email_address);
            $success = $mail->Send() && $success;
        }
        $bean->last_run = $timedate->getNow()->asDb(false);
        $bean->save();
        return true;
    }
}