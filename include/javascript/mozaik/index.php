<?php

session_start();
//session_destroy();
//exit;

if(!isset($_SESSION['template'])) {
	$_SESSION['template'] = file_get_contents('template.html');
}

if(@$_GET['f']=='save') {
	$_SESSION['template'] = $_POST['tpl'];
}
else if(@$_GET['f']=='load') {
	echo $_SESSION['template'];
}
else if(@$_GET['f']=='send') {
	
	$to = $_POST['email'];

	$subject = 'Mozaik Email Template Test';

	$headers = "From: Mozaik Test <noreply@mozaik.madsoft.hu>\r\n";
	//$headers .= "Reply-To: ". strip_tags($_POST['email']) . "\r\n";
	//$headers .= "CC: susan@example.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	$body = stripslashes($_POST['body']);
	
	if(mail($to, $subject, $body, $headers)) {
		echo 'sent';
	}
	else {
		echo 'mail failed';
	}
}
else {
	$html = $_SESSION['template'];
	include('index.html');
}




return;

// ------------------------------------ OLD VERSION: SAVE TO FILE...-----------------------------------


if(@$_GET['f']=='save') {
	file_put_contents('template.html', $_POST['tpl']);
}
else if(@$_GET['f']=='load') {
	echo @file_get_contents('template.html');
}
else if(@$_GET['f']=='send') {
	
	$to = $_POST['email'];

	$subject = 'Mozaik Email Template Test';

	$headers = "From: Mozaik Test <noreply@mozaik.madsoft.hu>\r\n";
	//$headers .= "Reply-To: ". strip_tags($_POST['email']) . "\r\n";
	//$headers .= "CC: susan@example.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	mail($to, $subject, $_POST['body'], $headers);
}
else {
	$html = @file_get_contents('template.html');
	include('index.html');
}
