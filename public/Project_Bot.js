function runScript(e) {
    if (e.keyCode == 13) {
        getResponse();;
        return false;
    }
}
function getResponse() {
	var str =  document.getElementById("chatform").elements[0].value;

    if (str.length == 0) {
       return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        	var new_item = document.createElement("div");
        xmlhttp.onreadystatechange = function() {
            if(this.readyState==1){
              new_item.appendChild(document.createTextNode(str));
            }
            if (this.readyState == 4 && this.status == 200) {
                new_item.setAttribute("style", "align:right;")
		            var myArr = JSON.parse(this.responseText);
                new_item.appendChild(document.createTextNode(myArr.reply));
	            }
            if(this.readyState ==1 || this.readyState==4){
                document.getElementById("chat_box").insertBefore(new_item,document.getElementById("chat_box").firstChild );
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
