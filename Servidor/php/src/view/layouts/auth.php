<?php
// file: view/layouts/welcome.php
$view = ViewManager::getInstance();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../../css/style.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;600&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
  <div id="flash">
			<?= $view->popFlash() ?>
		</div>
    <div class="mainContainer">
      <sidebar class="sidebar">
        <i class="fa-solid fa-x closeIcon"></i>
        <div class="logo logoMod">
          <h1 href="#">Iam</h1>
          <label class="switchLogo switchLogoMod">
            <input type="checkbox" />
            <span class="slider round"></span>
          </label>
          <h1>N</h1>
        </div>
        <ul>
          <a href="index.php?controller=toggle&amp;action=index"><?= i18n("MySwitches") ?></a>
          <a href="index.php?controller=toggle&amp;action=suscribed"><?= i18n("Subscribed") ?></a>
          <div class="sidebarFooter">
            <?php
              include(__DIR__."/language_select_element.php");
            ?>
            <a href="index.php?controller=users&amp;action=logout" class="logout"><?= i18n("Logout") ?></a>
            <div class="socialNetworks">
            <a href="https://google.com" target="_blank">
              <i class="fa-brands fa-instagram"></i
            ></a>
            <a href="https://google.com" target="_blank">
              <i class="fa-brands fa-twitter"></i
            ></a>
            <a href="https://google.com" target="_blank">
              <i class="fa-brands fa-linkedin"></i
            ></a>
            <a href="https://google.com" target="_blank">
              <i class="fa-brands fa-github"></i
            ></a>
          </div>
          </div>
        </ul>
      </sidebar>
      <div class="dashboardContainer">
        <nav class="dashboardNav">
          <i class="fa-solid fa-bars fa-xl sidebarIcon"></i>
          <i class="fa-regular fa-message"></i>
          <i class="fa-regular fa-user userIcon"></i>
          <div class="menu">
          <ul>
            <li><a href="#">Example</a></li>
            <li><a href="#">Example</a></li>
            <li><a href="#">Example</a></li>
            <li><a href="#">Example</a></li>
          </ul>
        </div>
        </nav>
        <nav class="dashboardButtons">
          <button id="addSwitch" class="GenericButton">
            <span><?= i18n("Add") ?></span>
          </button>
          <select class="dashboardSelect" name="select">
            <option value="id" selected>Id</option>
            <option value="nombre"><?= i18n("Name") ?></option>
            <option value="usuario"><?= i18n("Username") ?></option>
            <option value="fecha"><?= i18n("Date") ?></option>
          </select>
        </nav>
          <?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
          <div class="modalWindow" id="modalWindow">
    <form class="modal" action="index.php?controller=Toggle&amp;action=add" method="POST">
    <i id="close" class="fa-solid fa-x fa-m"></i>
    <h1><?= i18n("Add") ?></h1>
    <input type="text" name="name" placeholder="<?= i18n("Name") ?>" required />
    <input type="text" name="description" placeholder="<?= i18n("Description") ?>" />
    <label><?= i18n("State") ?></label>
    <input type="checkbox" name="state" id="stateCheckbox" />
    <div id="durationField">
        <label><?= i18n("Format") ?></label>
        <input type="text" name="shutdown_date" placeholder="YYYY-MM-DD HH:MM:SS" />
    </div>
    <button id="createSwitch" type="submit" class="GenericButton">
        <span><?= i18n("Create") ?></span>
    </button>
</form>
    </div>
    
        
  </body>
  <script
    src="https://kit.fontawesome.com/19c59e2dfc.js"
    crossorigin="anonymous"
  ></script>
  <script type="text/javascript" src="../../js/dashboard.js"></script>
</html>