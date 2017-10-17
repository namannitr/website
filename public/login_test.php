<?php

if($_POST["username"]=="student"){
	echo "student";
}
else {
	echo "teacher";
}


try{
//echo $_GET['message'];
$statement = $conn->prepare("select * from student where student_id = :st_id and student_pass = :st_pw");
 $statement->execute(array(
"st_id" => $_POST['username'],
"st_pw" => $_POST['password']));
//$statement = $conn->prepare("SELECT * FROM response_message order by message_id desc limit 1");
//$statement->execute();
//print_r($satement->errorInfo());
$row = $statement->fetch();


//echo "<td>";
//echo "Message: ";
//echo $_GET['message'];
//echo "</td><td>";
//echo "Reply: ";
//echo $row["message_body"];
//echo "</td>";
//$reply = array("message" => $_GET['message'], "reply" =>$row["message_body"]);
//echo json_encode($reply);
echo  row;
echo "Naman";
}

catch(PDOException $e)
    { //Testing Git ...
    echo "Connection failed: " . $e->getMessage();
    }
//return;
?>


?>
