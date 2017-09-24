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

            if(this.readyState==1){
              var new_item = document.createElement("div");
              var text = document.createElement("span");
              text.setAttribute("style", "color:blue;");
              text.appendChild(document.createTextNode(str));

              var new_item_2 = document.createElement("div");
              var text_2 = document.createElement("span");
              new_item_2.setAttribute("align", "right");
              text_2.setAttribute("style", "color:green;");
              text_2.appendChild(document.createTextNode("..."));

              new_item.appendChild(text);
              document.getElementById("chat_box").insertBefore(new_item,document.getElementById("chat_box").firstChild );

              new_item_2.appendChild(text_2);
              document.getElementById("chat_box").insertBefore(new_item_2,document.getElementById("chat_box").firstChild );
            }
            if (this.readyState == 4 && this.status == 200) {

		            var myArr = JSON.parse(this.responseText);
                text_2.innerHTML= myArr.reply;
                if(document.getElementById("tts").checked == true){
                  responsiveVoice.speak(myArr.reply, "Hindi Female");
                }
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
