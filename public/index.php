<html>
	<head>
	<title> Naman </title>
<script>
function runScript(e) {
    if (e.keyCode == 13) {
        getResponse();;
        return false;
    }
}
function getResponse() {
	var str =  document.getElementById("chatform").elements[0].value;
    if (str.length == 0) { 
        document.getElementById("response").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
		var myArr = JSON.parse(this.responseText);
		var row = document.createElement("tr");
                var col1 = document.createElement("td");
                var col2 = document.createElement("td");
		//var col1Text = document.createTextNode("Naman");
                //var col2Text = document.createTextNode("Agarwal");
		var col1Text = document.createTextNode(myArr.message);
                var col2Text = document.createTextNode(myArr.reply);
		col1.appendChild(col1Text);
		col2.appendChild(col2Text);
		row.appendChild(col1);
		row.appendChild(col2);
                //tbody.apl
		document.getElementById("response").appendChild(row);
            }
        };
        xmlhttp.open("GET", "insert.php?message=" + str, true);
        xmlhttp.send();
    }
}
</script>


	</head>
	<body>
	<form id="chatform">
  Message :<br>
  <input type="text" name="message" value="Enter Your Message here" onkeypress="return runScript(event)"><br>
</form>	
<button type="button" onclick="getResponse()">submit</button>

<div id="response1">
<div>
<table id="response" border="1">
<tr>
<th>Message</ th>
<th>Reply</ th>
</tr>
</table>
</body>
</html>
