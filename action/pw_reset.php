<?php

require('../config/site.php');

if(isset($_SESSION['user'])) {
	header('Location: '.$site_url);
	die();
}

require('../config/database.php');
include('../includes/functions.php');
// Error Codes:
// 1 = Empty
// 2 = Fail
// 3 = Invalid captcha

if(isset($_POST['email'])) {
	$email = $_POST['email'];
	$send = send_email($email);
	if($send == '1') {
		header('Location: '.$site_url.'forgot password?success=true');
	} else {
		header('Location: '.$site_url.'forgot password?email='.$email.'&errorcode=2');
	}
} else {
	header('Location: '.$site_url.'forgot password?email='.$email.'&errorcode=3');
}

?>