<!DOCTYPE html>
<html class="mdc-typography">
  <head>
    <title>Naman's Website</title>
    <link rel="stylesheet"
          href="node_modules/material-components-web/dist/material-components-web.css">
     <link rel="stylesheet"
          href="node_modules/material-design-icons-master/iconfont/material-icons.css">
  </head>
  <body bgcolor="black">
    <header class="mdc-toolbar mdc-toolbar--fixed mdc-toolbar--waterfall" style="height: 70px;">
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
             <a href="#" class="material-icons mdc-toolbar__icon" aria-label="Print this page" alt="Print this page">print</a>
             <a href="#" class="material-icons mdc-toolbar__icon" aria-label="Bookmark this page" alt="Bookmark this page">bookmark</a>
           </section>
         </div>
       </header>
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
