<?php
//file: view/users/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", i18n("Dashboard"));
$errors = $view->getVariable("errors");
$suscribedToggles = $view->getVariable("suscribedToggles");

function displaySubscribedToggles($suscribedToggles) {
    foreach ($suscribedToggles as $suscribedToggle) {
        echo '<div class="switchBox">';
        echo '<label class="switch">';
        echo '<input type="checkbox" checked="' . ($suscribedToggle->getState() ? 'checked' : '') . '"/>';
        echo '<span class="slider round"></span>';
        echo '</label>';
        echo '<div class="switchText">';
        echo '<h3> <strong>' . i18n("Name") . ': ' . $suscribedToggle->getToggleName() . '</strong></h3>';
        echo '<h3>' . i18n("User") . ': ' . $suscribedToggle->getUsername() . '</h3>';
        echo '<p>' . i18n("description") . ' ' . $suscribedToggle->getDescription() . '</p>';
        echo '<p>' . i18n("Turn On Date") . ': ' . $suscribedToggle->getTurnOnDate() . '</p>';
        echo '</div>';
        echo '<div class="switchIcons">';
        echo '<a href="index.php?controller=Subscription&amp;action=unsubscribe&id=' . $suscribedToggle->getToggleId() . '"><i class="fa-regular fa-x"></i></a>';
        echo '<a href="index.php?controller=toggle&amp;action=toggleInformation&uri=' . $suscribedToggle->getPublicId() . '"><i class="fa-regular fa-share-from-square"></i></a>';
        echo '</div>';
        echo '</div>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../css/normalize.css" rel="stylesheet" />
    <link href="../../css/infoStyle.css" rel="stylesheet" />
    <title><?= i18n("Switch") ?></title>
</head>
<body>
<div class="switchContainer">
<?php
if (!empty($suscribedToggles)) {
    displaySubscribedToggles($suscribedToggles);
} else {
    echo '<h1>' . i18n("You are not subscribed to any switches.") . '</h1>';
}
?>
</div>
</body>
</html>
