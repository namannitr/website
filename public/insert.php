	<?php
include 'dbconnect.php';
try{
//echo $_GET['message'];
$statement = $conn->prepare("insert into received_message (eko_id, message_body,message_source, message_type, message_status) values (:ekoid, :body, :source, :type, :status)");
 $statement->execute(array(
"ekoid" => "EKO12345",
"body" => $_GET['message'],
"source" => 0,
"type" => 0,
"status" => 0));
sleep(1);
$statement = $conn->prepare("SELECT * FROM response_message order by message_id desc limit 1");
$statement->execute();
//print_r($satement->errorInfo());
$row = $statement->fetch();


//echo "<td>";
//echo "Message: ";
//echo $_GET['message'];
//echo "</td><td>";
//echo "Reply: ";
//echo $row["message_body"];
//echo "</td>";
$reply = array("message" => $_GET['message'], "reply" =>$row["message_body"]);
echo json_encode($reply);
}

catch(PDOException $e)
    { //Testing Git ...
    echo "Connection failed: " . $e->getMessage();
    }
return;
?>
