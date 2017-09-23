<!DOCTYPE html>
<html class="mdc-typography">
  <head>
    <title>Naman's Website</title>
    <link rel="stylesheet"
          href="node_modules/material-components-web/dist/material-components-web.css">
     <link rel="stylesheet"
          href="node_modules/material-design-icons-master/iconfont/material-icons.css">
    <style>
    .my-card-container .mdc-card {
      height: 350px;
      width: 350px;
    }
    </style>
  </head>
  <body bgcolor="black">
    <header class="mdc-toolbar mdc-toolbar--fixed " style="height: 70px;">
         <div class="mdc-toolbar__row">
           <section class="mdc-toolbar__section mdc-toolbar__section--align-start">
             <a href="#" class="material-icons mdc-toolbar__icon--menu">menu</a>
             <button class="mdc-fab mdc-fab--plain material-icons" aria-label="favorite" data-mdc-auto-init="MDCRipple">
               <img src="res/img/naman_profile.jpg" alt="Profile Photo" height="60" width="60"></img>
             </button>
           </section>
           <section class="mdc-toolbar__section">
             <span class="mdc-toolbar__title">Home</span>
           </section>
           <section class="mdc-toolbar__section mdc-toolbar__section--align-end" role="toolbar">
             <a href="#" class="material-icons mdc-toolbar__icon" aria-label="Download" alt="Download">file_download</a>
           </section>
         </div>
       </header>
       <div class="content">
         <nav class="mdc-permanent-drawer mdc-typography" style="left:0; top:70px; height:100%; position: fixed; width: 200px;" >
          <div class="mdc-list-group">
            <nav class="mdc-list">
              <a class="mdc-list-item mdc-permanent-drawer--selected" href="#">
                <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">inbox</i>Inbox
              </a>
              <a class="mdc-list-item" href="#">
                <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">star</i>Star
              </a>
              <a class="mdc-list-item" href="#">
                <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">send</i>Sent Mail
              </a>
              <a class="mdc-list-item" href="#">
                <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">drafts</i>Drafts
              </a>
            </nav>
          </div>
        </nav>
      </div>
      <div class="mdc-card">
  <section class="mdc-card__primary">
    <h1 class="mdc-card__title mdc-card__title--large">Title goes here</h1>
    <h2 class="mdc-card__subtitle">Subtitle here</h2>
  </section>
  <section class="mdc-card__supporting-text">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
    veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
    commodo consequat.
  </section>
  <section class="mdc-card__actions">
    <button class="mdc-button mdc-button--compact mdc-card__action">Action 1</button>
    <button class="mdc-button mdc-button--compact mdc-card__action">Action 2</button>
  </section>
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
