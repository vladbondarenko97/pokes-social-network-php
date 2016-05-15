<?php
if(isset($_SESSION['user'])) {
	header('Location: ' . $site_url);
	die();
}
$title = 'Login';
include '../includes/skin/header.php';
?>

<div>
<?php
if(isset($_GET['errorcode'])) {
	if($_GET['errorcode'] == 1) {
		echo '<div style="color:red">Error: One of the fields was left empty.</div>';
	} elseif($_GET['errorcode'] == 2) {
		echo '<div style="color:red">Error: Invalid e-mail/password. <a href="'.$site_url.'register">Click here</a> to sign-up.</div>';
	} else {
		echo '<div style="color:red">Error: An error has occurred.</div>';
	}
}
?>
<form action="action/login" method="POST">
<?php
if(isset($_GET['email']) && $_GET['email'] != NULL) {
	echo '<input type="text" name="email" placeholder="Email" value="' . $_GET['email'] . '" required autofocus />';
} else {
	echo '<input type="text" name="email" placeholder="Email" value="" required autofocus />';
}
?>
<br />
<input type="password" name="password" placeholder="Password" required />
<br />
<input type="submit" value="Sign In" /> <a href="forgot password">Forgot Password?</a>
</form>
</div>

<?php 
include '../includes/skin/footer.php';
?>