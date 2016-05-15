<?php

function safe($input) {
    return mysql_escape_string($input);
}

function login($email, $pass) {
// 1 = Success
// 2 = Fail
// 3 = Error
	$mysql = @mysql_query("SELECT * FROM users WHERE email='".safe($email)."' AND password='".safe($pass)."'");
	$rows = @mysql_num_rows($mysql);
	if($rows == 1) {
		return 1;
	} elseif($rows == 0) {
		return 2;
	} else {
		
	}
}

function vu($str) {
	$allowed = array('_');
	if(ctype_alnum(str_replace($allowed, '', $str))) {
		return '1';
	} else {
		return '0';
	}
}

function check_name($name) {
// 0 - Unavailable
// 1 - Available
// 2 - Invalid charachters
// 3 - Empty
// 4 - Invalid length
// 5 - Forbidden name
	$name = trim(safe($name));
	$forbidden_usernames = array('admin', 'administrator', 'support', 'faggot', 'pussy', 'nigger', 'nigga', 'fuck', 'fucker', 'gay', 'ass');
	foreach($forbidden_usernames as $fu) {
		if(strtolower($name) == $fu) {
			return 5;
			die();
		}
	}
	if($name == NULL) {
		return 3;
		die();
	}
	$len = strlen($name);
	if($len < 3 || $len > 15) {
		return 4;
		die();
	}
	// if(preg_match('/^[A-Za-z0-9_]+$/', $name)) {
	if(vu($name) != '1') {
    		return 2;
    		die();
    	}
	$query = mysql_query("SELECT * FROM users WHERE username = '".strtolower($name)."'");
        $check = mysql_num_rows($query);
	if($check != 0) {
		return 0;
		die();
	} else {
		return 1;
		die();
	}
}

function register($fname, $lname, $user, $pass, $email, $sex, $rank = 1, $banned = 0, $approved = 0) {
// 1 = success
// 2 = Unavailable username
// 3 = Invalid characters (username)
// 4 = Invalid length <5 >15 (username)
// 5 = Invalid F/L name
// 6 = Invalid password <6 >15
// 7 = E-mail already taken
// 8 = Invalid e-mail
// 9 = Forbidden username
// 10 = F/L above 15 chars


//-Check_Name-\\
// 0 - Unavailable
// 1 - Available
// 2 - Invalid characters
// 3 - Empty
// 4 - Invalid length
// 5 - Forbidden name
// register('Vlad', 'Bondarenko', 'VladHQ', 'password', 'contactvlad1k@gmail.com', 'm');

	$fname = safe(trim(htmlentities($fname)));
	$lname = safe(trim(htmlentities($lname)));
	$user = safe(trim(htmlentities($user)));
	$pass = safe(trim(htmlentities($pass)));
	$email = safe(strtolower(trim(htmlentities($email))));
	$sex = safe(strtolower(trim(htmlentities($sex))));
	$regdate = date('m/d/Y');
	$check_name = check_name($user);
	
	if($check_name != 1) {
		if($check_name == 0) {
			return 2;
			die();
		} elseif($check_name == 2) {
			return 3;
			die();
		} elseif($check_name == 3 || $check_name == 4) {
			return 4;
			die();
		} elseif($check_name == 5) {
			return 9;
			die();
		} else {
			return 'Error: ' . $check_name;
			die();
		}
	}


	if($fname == NULL || $lname == NULL) {
		return 5;
		die();
	}
	if(strlen($fname) > 15 || strlen($lname) >15) {
		return 10;
		die();
	}
	if(strlen($pass) < 6) {
		return 6;
		die();
	}
	if(strlen($pass) > 15) {
    		return 6;
		die();
	}
	$qry = "SELECT * FROM users WHERE email = '".$email."'";
	$sqlmembers = mysql_query($qry);
	$name_check = mysql_fetch_array($sqlmembers);
	$checkemail = mysql_num_rows($sqlmembers);
	if($checkemail != 0) {
		return 7;
		die();
	}
	if(!preg_match("/.*@.*..*/", $email) || preg_match("/(<|>)/", $email)) {
		return 8;
		die();
	}
	$insert = "INSERT INTO users (
    	    fname,
    	    lname,
            username,
            password,
            regdate,
            email,
            ip,
            lastip,
            rank,
            sex,
            banned,
            approved)
            VALUES (
            '".$fname."',
            '".$lname."',
            '".$user."',
            '".$pass."',
            '".$regdate."',
            '".$email."',
            '".$_SERVER['REMOTE_ADDR']."',
            '".$_SERVER['REMOTE_ADDR']."',
            '".$rank."',
            '".$sex."',
            '".$banned."',
            '".$approved."')";
	mysql_query($insert) or die(mysql_error());
	
	// Insert pokes
	$user_id = user2id($user);
	$insert = "INSERT INTO pokes (
	    id,
    	    pokes)
            VALUES (
            '".$user_id."',
            '0')";
	mysql_query($insert) or die(mysql_error());
	
	// Insert pokes_cooldown
	$insert = "INSERT INTO pokes_cooldown (
	    id,
    	    time)
            VALUES (
            '".$user_id."',
            '0')";
	mysql_query($insert) or die(mysql_error());
	return 1;
}

function get_real_name($user) {
	$user = safe(trim(htmlentities($user)));
	$mysql = mysql_query("SELECT * FROM users WHERE username='$user' LIMIT 1");
	$fname = mysql_result($mysql, 0, 'fname');
	$lname = mysql_result($mysql, 0, 'lname');
	return $fname.' '.$lname;
}

function get_username($user) {
	$user = safe(trim(htmlentities($user)));
	$mysql = mysql_query("SELECT * FROM users WHERE username='$user' LIMIT 1");
	$username = mysql_result($mysql, 0, 'username');
	return $username;
}

function get_cooldown($user) {
	$user = safe(trim(htmlentities($user)));
	$user_id = user2id($user);
	$mysql = mysql_query("SELECT * FROM pokes_cooldown WHERE id='$user_id' LIMIT 1");
	$time = mysql_result($mysql, 0, 'time');
	return $time;
}

function send_email($email) {
	$email = safe(trim(htmlentities($email)));
	$user = email2user($email);
	$user_id = user2id($user);
	$mysql = mysql_query("SELECT * FROM users WHERE id='$user_id' LIMIT 1");
	$number = mysql_num_rows($mysql);
	if($number != '0') {
		$password = mysql_result($mysql, 0, 'password');
		$subject = 'Pokes - Password Recovery';
		$message = 'Hey '.$user.'! You have recently requested a password recovery. Your current Pokes password is '.$password.'. Thanks for using Pokes!';
		$headers = 'From: contactvlad1k@gmail.com' . "\r\n" .
    			   'Reply-To: contactvlad1k@gmail.com' . "\r\n" .
    			   'X-Mailer: PHP/' . phpversion();

		mail($email, $subject, $message, $headers);
		$success = 1;
	} else {
		$success = 2;
	}
	return $success;
}

function is_approved($user) {
	$user = safe(trim(htmlentities($user)));
	$user_id = user2id($user);
	$mysql = mysql_query("SELECT * FROM users WHERE id='$user_id' LIMIT 1");
	$approved = mysql_result($mysql, 0, 'approved');
	$rank = mysql_result($mysql, 0, 'rank');
	if($approved == '1') {
		$approved = '<img src="http://vlad.tk/pokes/images/approved.ico" height="13px" width="13px" title="Verified"/> ';
	} else {
		$approved = ' ';
	}
	if($rank > '1') {
		$approved = '<img src="http://vlad.tk/pokes/images/approved.ico" height="13px" width="13px" title="Official personnel."/><img src="http://vlad.tk/pokes/images/admin.png" height="13px" width="13px" title="Administrator"/> ';
	}
	return $approved;
}

function get_gender($user) {
	$user = safe(trim(htmlentities($user)));
	$user_id = user2id($user);
	$mysql = mysql_query("SELECT * FROM users WHERE id='$user_id' LIMIT 1");
	$gender = mysql_result($mysql, 0, 'sex');
	if(strtolower($gender) == 'm') {
		$sex = 'Male';
	} elseif(strtolower($gender) == 'f') {
		$sex = 'Female';
	} else {
		$sex = 'Unknown';
	}
	return $sex;
}

function is_admin($user) {
	$user = safe(trim(htmlentities($user)));
	$user_id = user2id($user);
	$mysql = mysql_query("SELECT * FROM users WHERE id='$user_id' LIMIT 1");
	$rank = mysql_result($mysql, 0, 'rank');
	if($rank > 1) {
		$admin = true;
	} else {
		$admin = false;
	}
	return $admin;
}

function email2user($email) {
	$email = safe(trim(htmlentities(strtolower($email))));
	$mysql = mysql_query("SELECT * FROM users WHERE email='$email' LIMIT 1");
	$number = mysql_num_rows($mysql);
	if($number == '1') {
		$username = mysql_result($mysql, 0, 'username');
	} else {
		$username = '';
	}
	return $username;
}

function user2id($user) {
	$user = safe(trim(htmlentities(strtolower($user))));
	$mysql = mysql_query("SELECT * FROM users WHERE username='$user' LIMIT 1");
	$id = @mysql_result($mysql, 0, 'id');
	return $id;
}

function id2user($user) {
	$id = safe(trim(htmlentities(strtolower($user))));
	$mysql = mysql_query("SELECT * FROM users WHERE id='$id' LIMIT 1");
	$username = @mysql_result($mysql, 0, 'username');
	return $username;
}

function get_description($user) {
	$user = safe(trim(htmlentities(strtolower($user))));
	$id = user2id($user);
	$mysql = mysql_query("SELECT * FROM users WHERE id='$id' LIMIT 1");
	$description = mysql_result($mysql, 0, 'description');
	return $description;
}

function user2pokes($user) {
	$user = safe(trim(htmlentities(strtolower($user))));
	$id = user2id($user);
	$mysql = mysql_query("SELECT * FROM pokes WHERE id='$id' LIMIT 1");
	$pokes = mysql_result($mysql, 0, 'pokes');
	return $pokes;
}

function bold($text) {
	return '<b>'.$text.'</b>';
}

function add_poke($to, $from, $reason, $time = 0) {
// 1 = Success
// 2 = Limited pokes
// 3 = Invalid reason
	if(!isset($reason) || $reason == NULL) {
		return 3;
		die();
	}
	$time = time();
	$to_id = user2id($to);
	$from_id = user2id($from);
	$reason = safe(trim(htmlentities($reason)));
	$cooldown = get_cooldown($from);
	
	if($time - $cooldown < 60 * 5) {
		return 2;
		die();
	}
	
	$update = "UPDATE pokes SET pokes = pokes + 1 WHERE id = '$to_id'";
	mysql_query($update);
	
	$update = "UPDATE pokes_cooldown SET time = $time WHERE id = '$from_id'";
	mysql_query($update);

	$insert = "INSERT INTO poke_history (`id`, `from`, `time`, `reason`) VALUES ('".$to_id."', '".$from_id."', '".$time."', '".$reason."')";
	mysql_query($insert);
	return 1;
}

function register_input_username() {
	$html = '
	<label class="control-label" for="username"><b>Pokes username</b></label>
	<div class="input-prepend">
	<span class="add-on">@</span>
	<input class="input-medium screen-name-validate serialize-me required-validate no-reset" id="username" maxlength="15" type="text" value="'.@$_GET['username'].'" placeholder="Desired username..." name="username" required/>
	</div>
	';
	return $html;
}

function input($name, $value, $text, $placeholder, $max = 15) {
	$html = '
	<label class="control-label" for="'. $name . '"><b>'. $text . '</b></label>
	<div class="input-prepend">
	<input class="input-medium screen-name-validate serialize-me required-validate no-reset" id="'. $name . '" maxlength="'.$max.'" type="text" value="'. $value . '" placeholder="'. $placeholder . '" name="'. $name . '" required/>
	</div>
	';
	return $html;
}

function input_password($name, $value, $text, $placeholder) {
	$html = '
	<label class="control-label" for="'. $name . '"><b>'. $text . '</b></label>
	<div class="input-prepend">
	<input class="input-medium screen-name-validate serialize-me required-validate no-reset" id="'. $name . '" maxlength="15" type="password" value="'. $value . '" placeholder="'. $placeholder . '" name="'. $name . '" required/>
	</div>
	';
	return $html;
}

function list_pokes($user) {
	$html = '';
	$user = safe(trim(htmlentities(strtolower($user))));
	$user = user2id($user);
	$mysql = mysql_query("SELECT * FROM poke_history WHERE id='$user' ORDER BY time DESC LIMIT 10");
	$number = mysql_num_rows($mysql);
	if($number == '0') {
		$html .= '<div>No pokes to display.</div>';
	} else {
		$html .= '<hr>';
		$n = 0;
		while($n < $number) {
			$from_id = @mysql_result($mysql, $n, 'from');
			$time = @mysql_result($mysql, $n, 'time');
			$reason = @mysql_result($mysql, $n, 'reason');
			
			$from = id2user($from_id);
			$approved = is_approved($from);
			$html .= '<b>From</b> <a href="http://vlad.tk/pokes/@'.$from.'">@'.$from.'</a>'.$approved.'<br/><b>Reason</b> '.$reason.'<hr>';
			$n++;
		}
	}
	
	
	return $html;
}

function get_top() {
	$site_url = 'http://vlad.tk/pokes/';
	$mysql = mysql_query("SELECT * FROM pokes ORDER BY id,pokes DESC LIMIT 100");
	$number = mysql_num_rows($mysql);
	$n = 0;
	$table = 0;
	$html = '<table width="50%" style="table-layout:fixed;">';
	$html .= '<tr><th width="5%">#</th><th>Username</th><th width="15%"># of Pokes</th><th>Description</th></tr>';
	while($n < $number) {
		$table++;
		$id = @mysql_result($mysql, $n, 'id');
		$pokes = @mysql_result($mysql, $n, 'pokes');
		$user = id2user($id);
		$user_approved = is_approved($user);
		$description = get_description($user);
		if($description == NULL) {
			$description = '<i>Empty</i>';
		}
		if(strlen($description) > 60) {
			$description = mb_substr($description, 0, 60).'...';
		}
		$html .= '<tr><td>&nbsp;' . bold($table) . '.</td><td><a href="' . $site_url . '@' . $user . '">' . bold('@' . $user) . '</a>' . $user_approved . '</td><td style="text-align: center;">' . bold($pokes) . ' pokes</td><td style="text-align: center;">' . $description . '</td></tr>';
		$n++;
	}
	$html .= '</table>';
	return $html;
}

?>