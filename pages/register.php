<?php
if(isset($_SESSION['user']) && $_SESSION['user'] != NULL) {
	header('Location: ' . $site_url . 'index.php');
	die();
}
$title = 'Registration';
include '../includes/skin/header.php';
?>

<div>
<?php
if(isset($_GET['errorcode'])) {
	if($_GET['errorcode'] == 1) {
		echo '<div style="color:lime">Success: You have successfully registered an account.</div>';
	} elseif($_GET['errorcode'] == 2) {
		echo '<div style="color:red">Error: Username already taken.</div>';
	} elseif($_GET['errorcode'] == 3) {
		echo '<div style="color:red">Error: Username contains invalid characters.</div>';
	} elseif($_GET['errorcode'] == 4) {
		echo '<div style="color:red">Error: Username must be more than 4 characters and less than 16 characters.</div>';
	} elseif($_GET['errorcode'] == 5) {
		echo '<div style="color:red">Error: Invalid first/last name.</div>';
	} elseif($_GET['errorcode'] == 6) {
		echo '<div style="color:red">Error: Passwords must be above 5 and below 16 characters.</div>';
	} elseif($_GET['errorcode'] == 7) {
		echo '<div style="color:red">Error: E-mail is already taken.</div>';
	} elseif($_GET['errorcode'] == 8) {
		echo '<div style="color:red">Error: Invalid e-mail.</div>';
	} elseif($_GET['errorcode'] == 9) {
		echo '<div style="color:red">Error: Username is unavailable.</div>';
	} elseif($_GET['errorcode'] == 10) {
		echo '<div style="color:red">Error: First/Last name is over 15 characters.</div>';
	} elseif($_GET['errorcode'] == 11) {
		echo '<div style="color:red">Error: Passwords don\'t match.</div>';
	} elseif($_GET['errorcode'] == 12) {
		echo '<div style="color:red">Error: You are not a human? Please stop tampering with forms. Attempt has been logged, along with your IP.</div>';
		file_put_contents('important.txt', $_SERVER['REMOTE_ADDR'].PHP_EOL, LOCK_EX | FILE_APPEND);
	} else {
		echo '<div style="color:red">Error: An error has occured.</div>';
	}
}
?>
<style>
input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 1000px white inset;
}
</style>
<form action="<?php echo $site_url; ?>action/register" method="POST" autocomplete="off">
<?php

$random = rand(0, 10000);
echo input('email', @$_GET['email'], 'Email', 'example@mail.com', '64');
echo register_input_username();
echo input('fname', @$_GET['fname'], 'First Name', 'John');
echo input('lname', @$_GET['lname'], 'Last Name', 'Doe');
echo input_password('password', '', 'Desired Password', 'mypassword' . $random);
echo input_password('confirm_password', '', 'Retype Password', 'mypassword' . $random);

?><br />
<div><span><input type="radio" name="gender" value="male" checked/>Male &nbsp;</span>
<span><input type="radio" name="gender" value="female">Female</span></div>
<input type="submit" value="Register" />
</form>
</div>

<?php 
include '../includes/skin/footer.php';
?>