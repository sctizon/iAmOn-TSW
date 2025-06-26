<?php
//file: view/users/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", i18n("Login"));
$errors = $view->getVariable("errors");
?>

<div class="signUpIn">
    <div class="container">
        <div class="formContainer">
            <div class="registerContainer">
                <div class="logo">
                    <h1 href="index.php?controller=users&amp;action=login"><?= i18n("Iam") ?></h1>
                    <label class="switchLogo">
                        <input type="checkbox" />
                        <span class="slider round"></span>
                    </label>
                    <h1><?= i18n("N") ?></h1>
                </div>
            </div>
            <div class="ejemplo">
                <form class="loginForm" action="index.php?controller=users&amp;action=login" method="POST">
                    <input type="text" name="username" placeholder="<?= i18n("Username") ?>"> 
                    <input type="password" name="passwd" placeholder="<?= i18n("Password") ?>">
                    <button id="btn" class="submitButton" type="submit">
                        <span><?= i18n("Log In") ?></span>
                    </button>
                </form>
            </div>
            <div class="loginLinks">
                <a href="./forgotPassword.html"><?= i18n("Forgot Password?") ?></a>
                <a href="index.php?controller=users&amp;action=register"><?= i18n("Don't have an account?") ?></a>
            </div>
        </div>
    </div>
</div>
