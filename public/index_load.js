function sign_in() {
  var sign_in_sec = document.getElementById("sign_in_section");
  sign_in_sec.innerHTML="";

  var signed_in_text = document.createElement("span");
  signed_in_text.setAttribute("class", "mdc-typography--subheading2");
  signed_in_text.innerHTML="Welcome";

  sign_in_sec.appendChild(signed_in_text);
//  <input type="text" class="mdc-textfield__input" name="message" id="message">
}
function submit_username() {
  var sign_in_sec = document.getElementById("sign_in_section");

  sign_in_sec.innerHTML="";

  var username_text_box = document.createElement("input");
  username_text_box.setAttribute("class", "mdc-textfield__input");
  username_text_box.setAttribute("Value", "password");
  username_text_box.setAttribute("style","color:black; background:white; height:28px; text-align:center; text-transform:lowercase;");

  var submit_username_button = document.createElement("button");
  submit_username_button.setAttribute("class","mdc-button mdc-button--compact mdc-button--accent");
  submit_username_button.setAttribute("data-mdc-auto-init", "MDCRipple");
  submit_username_button.setAttribute("onclick", "sign_in()");
  submit_username_button.innerHTML="Submit";

  sign_in_sec.appendChild(username_text_box);
  sign_in_sec.appendChild(submit_username_button);
//  <input type="text" class="mdc-textfield__input" name="message" id="message">
}
  function sign_in_click() {
    var sign_in_sec = document.getElementById("sign_in_section");

    sign_in_sec.innerHTML="";

    var username_text_box = document.createElement("input");
    username_text_box.setAttribute("class", "mdc-textfield__input");
    username_text_box.setAttribute("Value", "Username");
    username_text_box.setAttribute("style","color:black; background:white; height:28px; text-align:center; text-transform:lowercase;");
    username_text_box.onfocus = function(){
      username_text_box.setAttribute("Value", "");
    };
    username_text_box.onfocusout = function(){
      if(username_text_box.value == ""){
        username_text_box.setAttribute("Value", "username");
      }
    };

    var submit_ussername_button = document.createElement("button");
    submit_ussername_button.setAttribute("class","mdc-button mdc-button--compact mdc-button--accent");
    submit_ussername_button.setAttribute("data-mdc-auto-init", "MDCRipple");
    submit_ussername_button.setAttribute("onclick", "submit_username()");
    submit_ussername_button.innerHTML="Submit";

    sign_in_sec.appendChild(username_text_box);
    sign_in_sec.appendChild(submit_ussername_button);
  //  <input type="text" class="mdc-textfield__input" name="message" id="message">
  }
