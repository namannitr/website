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
    <div class="content">
      <nav class="mdc-permanent-drawer mdc-typography">
        <nav id="navigation_drawer" class="mdc-list">
          <a class="mdc-list-item mdc-permanent-drawer--selected" href="#home">
            <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">send</i>Home
          </a>
          <a class="mdc-list-item" href="#">
            <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">send</i>Blog
          </a>
          <a class="mdc-list-item" href="#">
            <i class="material-icons mdc-list-item__start-detail" aria-hidden="false">send</i>Computer Science
          </a>
          <a class="mdc-list-item" href="#">
            <i class="material-icons mdc-list-item__start-detail" aria-hidden="false">send</i>Projects
          </a>
          <a class="mdc-list-item" href="#">
            <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">send</i>About Me
          </a>
        </nav>
      </nav>

      <div class="mdc-grid-list">
  <ul class="mdc-grid-list__tiles">
    <li class="mdc-grid-tile">
      <div class="mdc-grid-tile__primary">
        <img class="mdc-grid-tile__primary-content" src="my-image.jpg" />
      </div>
      <span class="mdc-grid-tile__secondary">
        <span class="mdc-grid-tile__title">Title</span>
      </span>
    </li>
    <li class="mdc-grid-tile">
      <div class="mdc-grid-tile__primary">
        <img class="mdc-grid-tile__primary-content" src="my-image.jpg" />
      </div>
      <span class="mdc-grid-tile__secondary">
        <span class="mdc-grid-tile__title">Title</span>
      </span>
    </li>
  </ul>
</div>


    </div>
    <script src="../node_modules/material-components-web/dist/material-components-web.js"></script>
    <script>mdc.autoInit()</script>
  </body>
</html>
