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
