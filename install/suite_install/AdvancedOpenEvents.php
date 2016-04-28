<?php

function install_aoe() {
    require_once('modules/Administration/Administration.php');
    require_once('modules/EmailTemplates/EmailTemplate.php');

    $emailTemp = new EmailTemplate();
    //$emailTemp->id = '7b618b3d-913b-6d2d-6bfb-519f7948a271';
    $emailTemp->date_entered = '2013-05-24 14:31:45';
    $emailTemp->date_modified = '2013-05-30 14:37:12';
    $emailTemp->name = 'Event Invite Template';
    $emailTemp->description = 'Default event invite template.';
    $emailTemp->published = 'off';
    $emailTemp->subject = "You have been invited to \$fp_events_name";
    $emailTemp->body = "Dear \$contact_name,\r\nYou have been invited to \$fp_events_name on \$fp_events_date_start to \$fp_events_date_end\r\n\$fp_events_description\r\nYours Sincerely,\r\n";
    $emailTemp->body_html = "\n<p>Dear \$contact_name,</p>\n<p>You have been invited to \$fp_events_name on \$fp_events_date_start to \$fp_events_date_end</p>\n<p>\$fp_events_description</p>\n<p>If you would like to accept this invititation please click accept.</p>\n<p> \$fp_events_link or \$fp_events_link_declined</p>\n<p>Yours Sincerely,</p>\n";
    $emailTemp->type = 'email';
    $emailTemp->save();
}
