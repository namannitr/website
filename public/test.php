<?php
include 'dbconnect_test.php';
?>
<html  class="mdc-typography">
	<head>
	<title> Naman's Website </title>
	<link rel="stylesheet"
          href="node_modules/material-components-web/dist/material-components-web.css">
	</head>
	<body>
<div class="mdc-component__containers__primary">
<div class="mdc-card" style="width:500px; margin:50 auto;" >
  <section class="mdc-card__primary">
<h3 class="mdc-typography--display1" style="width:150px; margin:10 auto;">Login:</h3>
	<form id="chatform" method="POST" action="login_test.php">
<div class="mdc-textfield" data-mdc-auto-init="MDCTextfield" style="width:300px;">
 <input type="text" class="mdc-textfield__input" name="username" id="username" onkeypress="return runScript(event)" >
<label for="message" class="mdc-textfield__label"> Enter Your Username Here: </label>
</div>
<div class="mdc-textfield" data-mdc-auto-init="MDCTextfield" style="width:300px;">
 <input type="password" class="mdc-textfield__input" name="password" id="password" onkeypress="return runScript(event)" >
<label for="password" class="mdc-textfield__label"> password </label>
</div>
<br>
<button class="mdc-button mdc-button--raised" data-mdc-auto-init="MDCRipple">submit</button>
</form>
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
