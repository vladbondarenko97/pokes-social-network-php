<?php
if(isset($_GET['u']) && $_GET['u']) {
	$user = $_GET['u'];
	$user_id = user2id($user);
	if(!is_numeric($user_id)) {
		$error = true;
		$title = 'Error';
	} else {
		$user = get_username($user);
		$title = '@'.$user;
		$at_user = $title;
		$user_pokes = user2pokes($user);
		$user_rn = get_real_name($user);
		$user_gender = get_gender($user);
		$user_approved = is_approved($user);
		$error = false;
	}	
} else {
	header('Location: '.$site_url);
	die();
}
include '../includes/skin/header.php';

if(isset($_GET['errorcode']) && $_GET['errorcode'] != NULL && !isset($_GET['success'])) {
	$errorcode = $_GET['errorcode'];
	if($errorcode == 1) {
		$error_message = '<div style="color:red;">You must wait some time before you add another poke to this user.</div>';
	} elseif($errorcode == 2) {
		$error_message = '<div style="color:red;">You must supply a message along with your poke.</div>';
	} else {
		$error_message = '<div style="color:red;">Unknown error.</div>';
	}
	echo $error_message;
}
if(isset($_GET['success']) && !isset($_GET['errorcode'])) {
	echo '<div style="color:lime;">A poke has been successfully added to this user.</div>';
}

if($error == false) {
	if(isset($_SESSION['user']) && $_SESSION['user'] != NULL && strtolower($_SESSION['user']) != strtolower($user)) {
		$cooldown = get_cooldown($_SESSION['user']);
		$wait_time = time() - $cooldown;
		if($wait_time > 60 * 5) {
			$add_html = '
			<h2>Add Poke</h2>
			<form action="/action/add_poke.php" method="POST">
			<input type="hidden" name="user" value="'.$user.'"/>
			<input type="text" name="reason" placeholder="Message..." autofocus required /><br/>
			<input type="submit" value="Poke" />
			</form>';
		} else {
			$add_html = 'Please wait some time before you add another poke to this user.';
		}
	}
	echo '
	<b class="full-name" href="../">' . $user_rn . '</b>' . $user_approved . $at_user.'<br />
	<strong>'.$user_pokes.'</strong> Pokes<br/>
	<em>'.$user_gender.'</em><br/>';
	if(isset($add_html) && $add_html != NULL) {
		echo $add_html;
	}
	echo '<h2>Recent Pokes</h2>';
	echo list_pokes($user);
} else {
	echo '<b>Error:</b> User not found.';
}
include '../includes/skin/footer.php';
?>