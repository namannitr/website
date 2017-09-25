<!DOCTYPE html>
<html class="mdc-typography">
  <head>
    <title>Naman's Website</title>
    <link rel="stylesheet"
          href="../node_modules/material-components-web/dist/material-components-web.css">
     <link rel="stylesheet"
          href="../node_modules/material-design-icons-master/iconfont/material-icons.css">

  </head>
  <body>
    <header class="mdc-toolbar mdc-toolbar--waterfall">
      <div class="mdc-toolbar__row">
        <section class="mdc-toolbar__section mdc-toolbar__section--align-start">
          <a href="#menu_navigation_bar" class="material-icons mdc-toolbar__icon--menu">menu</a>
            <button class="mdc-fab material-icons" data-mdc-auto-init="MDCRipple">
              <img src="../res/img/naman_profile.jpg" style="max-width:100%; max-height:100%;">
            </button>
        </section>
        <section class="mdc-toolbar__section ">
          <span class="mdc-toolbar__title">Home</span>
        </section>
        <section class="mdc-toolbar__section mdc-toolbar__section--align-end">
          <a class="drawer-list__link" href="#sign_in">Sign in </a>
        </section>
      </div>
    </header>
    <script src="../node_modules/material-components-web/dist/material-components-web.js"></script>
    <script>mdc.autoInit()</script>
  </body>
</html>
