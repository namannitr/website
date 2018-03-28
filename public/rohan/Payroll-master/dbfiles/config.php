<?php
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "Nam@1695!!";
$mysql_database = "rohan";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Oops some thing went wrong");
mysql_select_db($mysql_database, $bd) or die("Oops some thing went wrong");

?>
