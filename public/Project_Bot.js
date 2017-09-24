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
        xmlhttp.onreadystatechange = function() {
          	var new_item = document.createElement("div");
            var text = document.createElement("span");
            if(this.readyState==1){
              text.setAttribute("style", "color:blue;");
              text.appendChild(document.createTextNode(str));
            }
            if (this.readyState == 4 && this.status == 200) {
                new_item.setAttribute("align", "right");
                  text.setAttribute("style", "color:green;");
		            var myArr = JSON.parse(this.responseText);
                text.appendChild(document.createTextNode(myArr.reply));
                var audio = new Audio('recent.mp3');
                audio.load();
                audio.play();
	            }
            if(this.readyState ==1 || this.readyState==4){
                new_item.appendChild(text);
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
