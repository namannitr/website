<!DOCTYPE html>
<html class="mdc-typography">
  <head>
    <title>Naman's Website</title>
    <link rel="stylesheet"
          href="node_modules/material-components-web/dist/material-components-web.css">
     <link rel="stylesheet"
          href="node_modules/material-design-icons-master/iconfont/material-icons.css">
    <script src="index_load.js"></script>
    <style>
    section.mdc-card__primary{
      margin:auto;
    }
    </style>

  </head>
  <body>
    <header class="mdc-toolbar mdc-toolbar--fixed " style="height: 70px;">
         <div class="mdc-toolbar__row">
           <section class="mdc-toolbar__section mdc-toolbar__section--align-start">
             <a href="#" class="material-icons mdc-toolbar__icon--menu">menu</a>
             <button class="mdc-fab mdc-fab--plain material-icons" aria-label="favorite" data-mdc-auto-init="MDCRipple">
               <div>
                 <img src="res/img/naman_profile.jpg" alt="Profile Photo" height="60" width="60"></img>
               </div>
             </button>
           </section>
           <section class="mdc-toolbar__section">
             <span class="mdc-toolbar__title">Home</span>
           </section>
           <section class="mdc-toolbar__section mdc-toolbar__section--align-end mdc-theme--dark" id="sign_in_section" role="toolbar">
             <button class="mdc-button mdc-button--compact mdc-button--accent" data-mdc-auto-init="MDCRipple" onclick="sign_in_click()" >Sign in</button>
           </section>
         </div>
       </header>
       <div class="content">
         <nav class="mdc-permanent-drawer mdc-typography" style="left:0; top:70px; height:100%; position: fixed; width: 200px;" >
          <div class="mdc-list-group">
            <nav class="mdc-list">
              <a class="mdc-list-item mdc-permanent-drawer--selected" href="#">
                <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">send</i>Blog
              </a>
              <a class="mdc-list-item" href="#">
                <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">send</i>Science
              </a>
              <a class="mdc-list-item" href="project_bot.php">
                <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">send</i>Projects
              </a>
              <a class="mdc-list-item" href="#">
                <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">send</i>About Me
              </a>
            </nav>
          </div>
        </nav>
      </div>
      <div id="main_body" class="mdc-component__containers__primary">
        <div class="mdc-card" style="height: 260px;width: 300px;position: absolute;left: 250px;top: 100px;">
              <section class="mdc-card__primary">
                <h1 class="mdc-card__title mdc-card__title--large">Personal Blog</h1>
                <h2 class="mdc-card__subtitle">My Thoughts, Views and Experiences</h2>
              </section>
        </div>

        <div class="mdc-card" style="height: 260px;width: 300px;position: absolute;left: 600px;top: 100px;">
            <section class="mdc-card__primary">
              <h1 class="mdc-card__title mdc-card__title--large">Computer Science</h1>
              <h2 class="mdc-card__subtitle">lets talk computer</h2>
            </section>
        </div>

        <div class="mdc-card" id="projects_card" style="height: 260px;width: 300px;position: absolute;left: 250px;top: 450px;">
          <section class="mdc-card__primary">
            <h1 class="mdc-card__title mdc-card__title--large">Projects</h1>
            <h2 class="mdc-card__subtitle">Explore my technical works</h2>
          </section>
        </div>
        <div class="mdc-card" style="height: 260px;width: 300px;position: absolute;left: 600px;top: 450px;">
            <section class="mdc-card__primary">
              <h1 class="mdc-card__title mdc-card__title--large">About Me</h1>
              <h2 class="mdc-card__subtitle">Know me more!</h2>
            </section>
        </div>
</div>

<div class="mdc-card" style="height: 100%; width: 400px;position: absolute; right:10px; top: 75px;">
    <section class="mdc-card__primary">
      <h2 class="mdc-card__subtitle">Whats new!</h2>
    </section>
</div>
<script>
var projects_card_var = document.getElementById('projects_card');
projects_card_var.style.cursor = 'pointer';
projects_card_var.onclick = function() {
  var win = window.open("project_bot.php", '_blank');
  win.focus();
};
</script>
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
