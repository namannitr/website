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
       // document.getElementById("response").innerHTML = "";
        return;
    } else {
			//Hello
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
	//	document.getElementById("response").appendChild(row);
        document.getElementById("response").insertBefore(row,document.getElementById("response").firstChild );  
	  }
        };
        xmlhttp.open("GET", "insert.php?message=" + str, true);
        xmlhttp.send();
    }
document.getElementById("chatform").elements[0].value="";
}
function setFocus(){
 document.getElementById("message").focus();
}
window.onload = setFocus;
</script>


	</head>
	<body>
<div class="mdc-component__containers__primary">
<div class="mdc-card" style="width:500px; margin:50 auto;" >
  <section class="mdc-card__primary">
<h3 class="mdc-typography--display1" style="width:150px; margin:10 auto;">Message:</h3>
	<form id="chatform">
<div class="mdc-textfield" data-mdc-auto-init="MDCTextfield" style="width:300px;"> 
 <input type="text" class="mdc-textfield__input" name="message" id="message" onkeypress="return runScript(event)" >
<label for="message" class="mdc-textfield__label"> Enter Your Message Here: </label>
</div>
</form>	
<button class="mdc-button mdc-button--raised" data-mdc-auto-init="MDCRipple"  onclick="getResponse()">submit</button>
<br> <br>
<table>
<tr>
<th>Message</ th>
<th>Reply</ th>
</tr>
</table>
<table id="response" border="1">
</table>
</section>
</div>
</div>
<footer class="mdc-toolbar" style="position: fixed; height: auto; bottom:0; left: 0;">
  <div class="mdc-toolbar__row">
    <section class="mdc-toolbar__section">
      <span class="mdc-toolbar__title">By: Naman K Agarwal</span>
    </section>
  </div>
</footer>
<script src="node_modules/material-components-web/dist/material-components-web.js"></script>
<script>mdc.autoInit()</script>
</body>
</html>
