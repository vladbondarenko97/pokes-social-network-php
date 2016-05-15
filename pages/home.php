<?php
$title = 'Home';
$page_file_name = basename($_SERVER['PHP_SELF']); 

if(isset($_SESSION['user']) && $page_file_name == 'index.php') {
	header('Location: '.$site_url.'home');
}

include '../includes/skin/header.php';
$message = '';

if(isset($_SESSION['is_a_new_user']) && $_SESSION['is_a_new_user'] == true) {
	if(isset($_GET['new'])) {
		$fb_desc = urlencode('Add '.$_SESSION['username'].' on Pokes, a fun social network where you poke, and get poked while climbing leaderboards! #pokes');
		$fb_title = urlencode($site_name);
		$fb_image = urlencode($site_url.'images/logo.gif?'.time());
		$fb_url = urlencode($site_url.$_SESSION['username']);
		$fb_share_url = 'http://www.facebook.com/sharer.php?s=100&p[title]='.$fb_title.'&p[summary]='.$fb_desc.'&p[url]='.$fb_url.'&p[images][0]='.$fb_image;
		$message .= '<br />Thanks for joining Pokes! We hope you like your experience so far. Spread the word by <a href="'.$fb_share_url.'">sharing on Facebook</a>.'; 
	} else {
	
	}
}
?>
<?php
if(isset($_SESSION['user'])) {
	$user = $_SESSION['user'];
	$approved_data = is_approved($user);
	$pokes = user2pokes($user);
	$real_name = get_real_name($user);
	echo 'Howdy, '.$real_name.$approved_data.'(<a href="'. $site_url .'logout">Logout</a>)';
	if(isset($message) && $message != NULL) {
		echo bold($message);
	}
	echo '<div>You have ' . bold($pokes) . ($pokes > 1 ? ' pokes' : ' poke') . ', your latest pokes will be available below.';
	echo '<h2>Recent Pokes</h2>';
	echo list_pokes($user);
} else {
	echo '<div>Welcome to Pokes, a fun community where you Poke to the top! If this is your first visit, <a href="'.$site_url.'register">Sign Up</a> and start Poking friends!<br /><br />If this is not your first visit, use the form below to Sign In.</div>';
	echo '
	<form action="'.$site_url.'action/login" method="POST">
	<input type="text" name="email" placeholder="Email" value="" required autofocus /><br />
	<input type="password" name="password" placeholder="Password" required /><br />
	<input type="submit" value="Sign In" />
	</form>
	';
}
echo '<br />';
include '../includes/skin/footer.php';
?>