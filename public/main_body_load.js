var projects_card_var = document.getElementById('projects_card');
projects_card_var.style.cursor = 'pointer';
projects_card_var.onclick = function () {
  //var win = window.open("project_bot.php", '_blank');
  //win.focus();

  var main_body = document.getElementById("main_body");
  main_body.innerHTML = "";

  /*var bot_script_load = document.createElement("script");
  bot_script_load.type = "application/javascript";
  bot_script_load.setAttribute("src", "Project_Bot.js");
  main_body.appendChild(bot_script_load);

  var tts_script_load = document.createElement("script");
  tts_script_load.setAttribute("src", "https://code.responsivevoice.org/responsivevoice.js");
  main_body.appendChild(tts_script_load);*/

  var div_primary_container = document.createElement("div");
  div_primary_container.setAttribute("class", "mdc-component__containers__primary");
  div_primary_container.setAttribute("style","position:absolute; left:370px; top:100px;");

  var div_card_bot = document.createElement("div");
  div_card_bot.setAttribute("class", "mdc-card");
  div_card_bot.setAttribute("style","width:500px; margin:50 auto;");

  var section_card_bot = document.createElement("section");
  section_card_bot.setAttribute("class", "mdc-card__primary");

  var heading_text = document.createElement("h3");
  heading_text.setAttribute("class", "mdc-typography--display1");
  heading_text.setAttribute("style", "width:150px; margin:10 auto;");
  heading_text.innerHTML = "Message:";
  section_card_bot.appendChild(heading_text);

  var form_chat = document.createElement("form");
  form_chat.setAttribute("id", "chatform");

  var div_text_field = document.createElement("div");
  div_text_field.setAttribute("class", "mdc-textfield");
  div_text_field.setAttribute("data-mdc-auto-init", "MDCTextfield");
  div_text_field.setAttribute("style","width:300px;");

  var input_text_message = document.createElement("input");
  input_text_message.setAttribute("type","text");
  input_text_message.setAttribute("class", "mdc-textfield__input");
  input_text_message.setAttribute("name","message");
  input_text_message.setAttribute("id","message");
  input_text_message.setAttribute("onkeypress", "return runScript(event)");
  div_text_field.appendChild(input_text_message);

  var label_text_message = document.createElement("label");
  label_text_message.setAttribute("for","message");
  label_text_message.setAttribute("class","mdc-textfield__label");
  label_text_message.innerHTML = "Enter Your Message Here:";
  div_text_field.appendChild(label_text_message);

  form_chat.appendChild(div_text_field);
  section_card_bot.appendChild(form_chat);

  var button_for_submit = document.createElement("button");
  button_for_submit.setAttribute("class","mdc-button mdc-button--raised");
  button_for_submit.setAttribute("data-mdc-auto-init", "MDCRipple");
  button_for_submit.setAttribute("onclick", "getResponse()");
  button_for_submit.innerHTML = "Submit";
  section_card_bot.appendChild(button_for_submit);

  var div_for_switch = document.createElement("div");
  div_for_switch.setAttribute("style","left: 150px; display: -webkit-inline-box; position: relative;");

  var div_switch_button = document.createElement("div");
  div_switch_button.setAttribute("class","mdc-switch");

  var input_switch_button = document.createElement("input");
  input_switch_button.setAttribute("type","checkbox");
  input_switch_button.setAttribute("id","tts");
  input_switch_button.setAttribute("class","mdc-switch__native-control");
  div_switch_button.appendChild(input_switch_button);

  var div_switch_background = document.createElement("div");
  div_switch_background.setAttribute("class","mdc-switch__background");

  var div_switch_knob = document.createElement("div");
  div_switch_knob.setAttribute("class","mdc-switch__knob");
  div_switch_background.appendChild(div_switch_knob);
  div_switch_button.appendChild(div_switch_background);
  div_for_switch.appendChild(div_switch_button);

  var label_switch = document.createElement("label");
  label_switch.setAttribute("for","basic-switch");
  label_switch.setAttribute("class","mdc-switch-label");
  label_switch.innerHTML = "TTS off/on";
  div_for_switch.appendChild(label_switch);
  section_card_bot.appendChild(div_for_switch);

  var break_line_1 = document.createElement("br");
  section_card_bot.appendChild(break_line_1);
  var break_line_2 = document.createElement("br");
  section_card_bot.appendChild(break_line_2);

  var div_chat_box = document.createElement("div");
  div_chat_box.setAttribute("id","chat_box");
  section_card_bot.appendChild(div_chat_box);
  div_card_bot.appendChild(section_card_bot);
  div_primary_container.appendChild(div_card_bot);
  main_body.appendChild(div_primary_container);

  mdc.autoInit();
};


//<script src="Project_Bot.js">
//</script>
//<script src="https://code.responsivevoice.org/responsivevoice.js"></script>
//<div class="mdc-component__containers__primary">
//<div class="mdc-card" style="width:500px; margin:50 auto;" >
//<section class="mdc-card__primary">
//<h3 class="mdc-typography--display1" style="width:150px; margin:10 auto;">Message:</h3>
//<form id="chatform">
//<div class="mdc-textfield" data-mdc-auto-init="MDCTextfield" style="width:300px;">
//<input type="text" class="mdc-textfield__input" name="message" id="message" onkeypress="return runScript(event)" >
//<label for="message" class="mdc-textfield__label"> Enter Your Message Here: </label>
//</div>
//</form>
//<button class="mdc-button mdc-button--raised" data-mdc-auto-init="MDCRipple"  onclick="getResponse()">submit</button>
//<div style="
//left: 150px;
//display: -webkit-inline-box;
//position: relative;
//">
//<div class="mdc-switch">
//<input type="checkbox" id="tts" class="mdc-switch__native-control" />
//<div class="mdc-switch__background">
//<div class="mdc-switch__knob"></div>
//</div>
//</div>
//<label for="basic-switch" class="mdc-switch-label">TTS off/on</label>
//</div>
//<br>
//<br>
//<div id="chat_box">
//</div>
//</section>
//</div>
//</div>
