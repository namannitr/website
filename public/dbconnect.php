<?php
$servername = "localhost";
$username = "root";
$password = "Nam@1695!!";

try {
    $conn = new PDO("mysql:host=$servername;dbname=eko_Project", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 //   echo "Naman"; 

}
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>
