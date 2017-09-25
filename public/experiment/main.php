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
          <a class="mdc-typography--subheading2" onclick="sign_in_func(); return false" style="this.style.cursor:pointer; margin-right:10px;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none'">Sign in </a>
        </section>
      </div>
    </header>
    <div class="content">
  <nav class="mdc-permanent-drawer mdc-typography">
    <nav id="icon-with-text-demo" class="mdc-list">
      <a class="mdc-list-item mdc-permanent-drawer--selected" href="#">
        <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">inbox</i>Inbox
      </a>
      <a class="mdc-list-item" href="#">
        <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">star</i>Star
      </a>
    </nav>
  </nav>
  <main>
    Page content goes here.
  </main>
</div>
    <script src="../node_modules/material-components-web/dist/material-components-web.js"></script>
    <script>mdc.autoInit()</script>
  </body>
</html>
