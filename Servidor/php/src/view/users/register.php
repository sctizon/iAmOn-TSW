<?php
//file: view/users/register.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
$user = $view->getVariable("user");
$view->setVariable("title", "Register");
?>

    <div class="signUpIn">
      <div class="container">
        <div class="formContainer">
          <div class="registerContainer">
            <div class="logo">
              <h1 href="./signIn.html">Iam</h1>
              <label class="switchLogo">
                <input type="checkbox" />
                <span class="slider round"></span>
              </label>
              <h1>N</h1>
            </div>
          </div>
<form class="loginForm" action="index.php?controller=users&amp;action=register" method="POST">
	<input type="text" name="username" placeholder="<?= i18n("Username") ?>" required
	value="<?= $user->getUsername() ?>">
	<?= isset($errors["username"])?i18n($errors["username"]):"" ?><br>

	<input type="password" name="passwd" placeholder="<?= i18n("Password") ?>" required
	value="<?= $user->getPasswd() ?>">
	<?= isset($errors["passwd"])?i18n($errors["passwd"]):"" ?><br>

  	<input type="email" name="email" placeholder="<?= i18n("Email") ?>"
	value="<?= $user->getEmail() ?>">
	<?= isset($errors["email"])?i18n($errors["email"]):"" ?><br>

	<button class="submitButton" type="submit">
              <span><?= i18n("Register") ?></span>
            </button>
			<a href="index.php?controller=users&amp;action=login"><?= i18n("Back to main page") ?></a>
</form>
</div>
</div>