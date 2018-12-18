<?php
class delEmailCls{
	function delEmailFunc(&$bean,$event,$arguments){
		require_once('modules/InboundEmail/InboundEmail.php');
		$inbouneEmail = new InboundEmail();
		$inbouneEmail->retrieve($bean->mailbox_id);
        $uid = $bean->uid;
		//Deleting the email on mail server also
        $inbouneEmail->deleteMessageOnMailServer($uid);
	}
}
