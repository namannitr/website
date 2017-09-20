<html  class="mdc-typography">
	<head>
	<title> Naman's Website </title>
	<link rel="stylesheet"
          href="node_modules/material-components-web/dist/material-components-web.css">
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
<div class="mdc-card" style="width:500px; margin:50 auto;" >
  <section class="mdc-card__primary">
<h3 class="mdc-typography--display1" style="width:150px; margin:10 auto;">Message:</h3>
	<form id="chatform">
  <input type="text" class="mdc-textfield__input" name="message" value="Enter Your Message here" onkeypress="return runScript(event)"><br>
</form>	
<button type="button" class="mdc-button  mdc-button--raised mdc-button--primary" onclick="getResponse()">submit</button>
<br> <br>
<table id="response" border="1">
<tr>
<th>Message</ th>
<th>Reply</ th>
</tr>
</table>
</section>
</div>
<script src="node_modules/material-components-web/dist/material-components-web.js"></script>
<script>mdc.autoInit()</script>
</body>
</html>
