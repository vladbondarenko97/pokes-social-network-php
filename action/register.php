<?php

require('../config/site.php');

if(isset($_SESSION['user'])) {
	header('Location: '.$site_url);
	die();
}

require('../config/database.php');
include('../includes/functions.php');

$fname = @$_POST['fname'];
$lname = @$_POST['lname'];
$username = @$_POST['username'];
$user = @$_POST['username'];
$pw1 = @$_POST['password'];
$pw2 = @$_POST['confirm_password'];
$email = @$_POST['email'];
$gender_get = @$_POST['gender'];

if($gender_get == 'male') {
	$gender = 'm';
} elseif($gender_get == 'female') {
	$gender = 'f';
} else {
	header('Location: '.$site_url.'register?errorcode=12&fname='.$fname.'&lname='.$lname.'&email='.$email.'&username='.$username);
	die();
}

if($pw1 != $pw2) {
	header('Location: '.$site_url.'register?errorcode=11&fname='.$fname.'&lname='.$lname.'&email='.$email.'&username='.$username);
	die();
}

$r_code = register($fname, $lname, $user, $pw1, $email, $gender);
if($r_code != 1) {
	header('Location: '.$site_url.'register?errorcode='.$r_code.'&fname='.$fname.'&lname='.$lname.'&email='.$email.'&username='.$username);
	die();
} else {
	$_SESSION['username'] = $username;
	$_SESSION['email'] = $email;
	$_SESSION['is_a_new_user'] = true;
	header('Location: '.$site_url.'home?new');
	die();
}

?>