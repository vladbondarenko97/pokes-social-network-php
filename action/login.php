<?php
require('../config/site.php');
require('../config/database.php');
include('../includes/functions.php');
// Error Codes:
// 1 = Empty
// 2 = Fail
// 3 = Error

if(isset($_POST['email']) && isset($_POST['password'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];
	$login = login($email, $password);
	if($login == '1') {
		$email = safe(trim(htmlentities(strtolower($email))));
		$user = email2user($email);
		$_SESSION['user'] = $user;
		$_SESSION['email'] = $email;
		header('Location: '.$site_url);
	} else {
		header('Location: '.$site_url.'login?email='.$email.'&errorcode=2');
	}
} else {
	header('Location: '.$site_url.'login?email='.$email.'&errorcode=1');
}

?>