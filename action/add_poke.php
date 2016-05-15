<?php

require('../config/site.php');
require('../config/database.php');
include('../includes/functions.php');

if(!isset($_SESSION['user'])) {
	file_put_contents('important.txt', $_SERVER['REMOTE_ADDR'].PHP_EOL.' tried accessing add_pokes.php without session.', FILE_APPEND | LOCK_EX);
	die('You are not authenticated.');
}

// Error Codes:
// 1 = Empty
// 2 = Fail
// 3 = Error

if(isset($_POST['user']) && isset($_POST['reason'])) {
	$to = $_POST['user'];
	$from = get_username($_SESSION['user']);
	if(strtolower($to) == strtolower($from)) {
		file_put_contents('important.txt', 'User: '.$from.'; IP:'.$_SERVER['REMOTE_ADDR'].'; Attempt to poke themselves.'.PHP_EOL, FILE_APPEND | LOCK_EX);
		die('You are not allowed to poke yourself.');
	}
	$reason = $_POST['reason'];
	$add_poke = add_poke($to, $from, $reason);
	if($add_poke == '1') {
		header('Location: '.$site_url.'@'.$to.'&success');
		die();
	} elseif($add_poke == '2') {
		header('Location: '.$site_url.'@'.$from.'&errorcode=1'); // limited pokes
		die();
	} elseif($add_poke == '3') {
		header('Location: '.$site_url.'@'.$from.'&errorcode=2'); // Invalid reason
		die();
	}
} else {
	header('Location: '.$site_url); // Empty fields
}

?>