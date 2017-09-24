<html  class="mdc-typography">
	<head>
	<title> Naman's Website </title>
	<link rel="stylesheet"
          href="node_modules/material-components-web/dist/material-components-web.css">
	</head>
	<body>
		<script src="Project_Bot.js">
		</script>
		<script src="https://code.responsivevoice.org/responsivevoice.js"></script>
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

<div class="mdc-switch mdc-switch--disabled">
  <input type="checkbox" id="another-basic-switch" class="mdc-switch__native-control" disabled />
  <div class="mdc-switch__background">
    <div class="mdc-switch__knob"></div>
  </div>
</div>
<label for="another-basic-switch" class="mdc-switch-label">off/on</label>
<br>
<br>
<div id="chat_box">
</div>
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
