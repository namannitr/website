<?php
echo htmlspecialchars(\"
		<script src=\"Project_Bot.js\">
		</script>
<div class=\"mdc-component__containers__primary\">
<div class=\"mdc-card\" style=\"width:500px; margin:50 auto;\" >
  <section class=\"mdc-card__primary\">
<h3 class=\"mdc-typography--display1\" style=\"width:150px; margin:10 auto;\">Message:</h3>
	<form id=\"chatform\">
<div class=\"mdc-textfield\" data-mdc-auto-init=\"MDCTextfield\" style=\"width:300px;\">
 <input type=\"text\" class=\"mdc-textfield__input\" name=\"message\" id=\"message\" onkeypress=\"return runScript(event)\" >
<label for=\"message\" class=\"mdc-textfield__label\"> Enter Your Message Here: </label>
</div>
</form>
<button class=\"mdc-button mdc-button--raised\" data-mdc-auto-init=\"MDCRipple\"  onclick=\"getResponse()\">submit</button>
<br> <br>
<table>
<tr>
<th>Message</ th>
<th>Reply</ th>
</tr>
</table>
<table id=\"response\" border=\"1\">
</table>
</section>
</div>
</div>
")
?>
