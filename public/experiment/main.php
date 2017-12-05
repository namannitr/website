<!DOCTYPE html>
<!check>
<html class="mdc-typography">
  <head>
    <title>Naman's Website</title>
    <link rel="stylesheet"
          href="../node_modules/material-components-web/dist/material-components-web.css">
     <link rel="stylesheet"
          href="../node_modules/material-design-icons-master/iconfont/material-icons.css">
    <style>
    .mdc-card {
      max-width: 350px;
    }
    </style>
  </head>
  <body>
    <header class="mdc-toolbar mdc-toolbar--waterfall">
      <div class="mdc-toolbar__row">
        <section class="mdc-toolbar__section mdc-toolbar__section--align-start">
            <button class="mdc-fab material-icons" data-mdc-auto-init="MDCRipple" style="margin-left:10px;">
              <img src="../res/img/naman_profile.jpg" style="max-width:100%; max-height:100%;">
            </button>
        </section>
        <section class="mdc-toolbar__section ">
          <span class="mdc-toolbar__title">Home</span>
        </section>
        <section class="mdc-toolbar__section mdc-toolbar__section--align-end">
          <a class="mdc-typography--subheading2" onclick="sign_in_func(); return false" style="cursor:pointer; margin-right:10px;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none'">Sign in </a>
        </section>
      </div>
    </header>
    <aside class="mdc-temporary-drawer mdc-typography">
      <nav class="mdc-temporary-drawer__drawer">
        <header class="mdc-temporary-drawer__header">
          <div class="mdc-temporary-drawer__header-content">
            Header here
          </div>
        </header>
        <nav id="icon-with-text-demo" class="mdc-temporary-drawer__content mdc-list">
          <a class="mdc-list-item mdc-temporary-drawer--selected" href="#">
            <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">inbox</i>Inbox
          </a>
          <a class="mdc-list-item" href="#">
            <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">star</i>Star
          </a>
        </nav>
      </nav>
</aside>
    <script src="../node_modules/material-components-web/dist/material-components-web.js"></script>
    <script>mdc.autoInit()</script>
  </body>
</html>
