<?php
// file: view/layouts/welcome.php

$view = ViewManager::getInstance();

?>
<!DOCTYPE html>
<html>
<head>
	<title><?= $view->getVariable("title", "no title") ?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<?= $view->getFragment("css") ?>
	<?= $view->getFragment("javascript") ?>
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
<?php
        include(__DIR__."/language_select_element.php");
    ?>
    <div class="signUpIn">
      
	<main>
		<!-- flash message -->
		<div id="flash">
			<?= $view->popFlash() ?>
		</div>
		<?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
	</main>
	<footer>
        <div class="footerContainer">
          <h4 class="inferior__titulo"><?= i18n("Follow us") ?></h4>
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
          <p><?= i18n("Rights") ?></p>
        </div>
    </footer>
    </div>
</body>
<script
    src="https://kit.fontawesome.com/19c59e2dfc.js"
    crossorigin="anonymous"
  ></script>
</html>