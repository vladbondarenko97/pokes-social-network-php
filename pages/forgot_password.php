<?php
if(isset($_SESSION['user']) || isset($_SESSION['reset'])) {
	header('Location: ' . $site_url . 'index.php');
	die();
}

$title = 'Password Recovery';
include '../includes/skin/header.php';
?>

<div>
<?php
if(isset($_GET['errorcode']) && !isset($_GET['success'])) {
	if($_GET['errorcode'] == 1) {
		echo '<div style="color:red">Error: Invalid e-mail.</div>';
	} elseif($_GET['errorcode'] == 2) {
		echo '<div style="color:red">Error: User with that e-mail doesn\'t exist.</div>';
	} elseif($_GET['errorcode'] == 3) {
		echo '<div style="color:red">Error: You left the e-mail empty.</div>';
	} elseif($_GET['errorcode'] == 4) {
		echo '<div style="color:red">Error: User has disabled password reminder for this account.</div>';
	} else {
		echo '<div style="color:red">Error: An error has occured.</div>';
	}
} elseif(!isset($_GET['errorcode']) && isset($_GET['success'])) {
	echo '<div style="color:lime">We have sent a password reminder e-mail. Thank you!</div>';
	$_SESSION['reset'] = 'true';
	include '../includes/skin/footer.php';
	die();
}
?>
<div>When you submit your e-mail, you will be sent an e-mail containing your Pokes password. You can only submit this form <b>once</b>.</dov>
<form action="action/pw_reset.php" method="POST">
<?php
if(isset($_GET['email']) && $_GET['email'] != NULL) {
	echo '<input type="text" name="email" placeholder="Email" value="' . $_GET['email'] . '" required autofocus />';
} else {
	echo '<input type="text" name="email" placeholder="Email" value="" required autofocus />';
}
?>
<br />
<input type="submit" value="Recover" />
</form>
</div>

<?php 
include '../includes/skin/footer.php';
?>