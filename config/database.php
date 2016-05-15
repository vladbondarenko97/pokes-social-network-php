<?php

$host = 'localhost';
$db_username = 'user';
$db_pass = 'pass';
$db_name = 'database';

$fst2 = substr($db_name, 0, 2);
$lst2 = substr($db_name, -2);
$secure_db = $fst2.'..'.$lst2;

$connection = mysql_connect($host, $db_username, $db_pass) or die ('Cannot connect to the MySQL server. (1)'); 
$db = mysql_select_db($db_name, $connection) or die ('Cannot choose database "'.$secure_db.'". (2)');

?>