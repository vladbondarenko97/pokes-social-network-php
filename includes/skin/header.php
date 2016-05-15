<!DOCTYPE html>
<html>
<head>
<title><?php
if(isset($title) && $title != NULL) {
	echo $site_name . ' - ' . $title;
} else {
	echo $site_name;
}
?></title>
<meta property="og:title" content="Pokes Social Network" />
<meta property="og:type" content="Social Network" />
<meta property="og:url" content="<?php echo $site_url; ?>" />
<meta property="og:image" content="<?php echo $site_url; ?>images/logo.gif" />
<meta property="og:site_name" content="Pokes"/>
<meta property="og:description" content="Pokes is a social network for users to poke people they love!"/>
<link rel="stylesheet" type="text/css" href="<?php echo $site_url; ?>includes/skin/home.css" media="screen" />
</head>
<body style="margin:15;">
<?php
echo '<h1><a href="' . $site_url . '"><img src="'.$site_url.'images/logo.gif" width="3%" height="3%" />' . $site_name . '</a></h1>'; // Site header
?>
<br/>
<a href="/">Home</a> || <a>Search</a> || <a href="/top">Top Leaderboards</a><?php

$is_admin = is_admin($_SESSION['user']);

if(isset($_SESSION['user']) && $is_admin == '1') {
	echo ' || <a href="./admin">Admin Menu</a>';
}
?><br/>