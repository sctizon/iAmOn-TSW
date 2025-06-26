<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Subscription.php");
require_once(__DIR__."/../model/SubscriptionMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

class SubscriptionController extends BaseController {
    private $subscriptionMapper;

    public function __construct() {
		parent::__construct();

		$this->subscriptionMapper = new SubscriptionMapper();

		$this->view->setLayout("welcome");
	}



            /**
 * Action to subscribe a toggle
 */
public function subscribe() {
    // Check if the user is logged in
    if (!$this->checkSession()) {
        throw new Exception("Not in session. subscribe toggles requires login");
    }

    // Get the current user from the session or your authentication system
    $currentUserId = $_SESSION['user_id']; // Adjust this based on your actual session structure

    // Get the ID of the toggle to be deleted
    $toggleId = (int)$_GET["id"];
    
    // Check if a valid toggle ID was provided
    if (!$toggleId) {
        throw new Exception("Invalid toggle ID provided");
    }

    // Get the Toggle object from the database
    $toggle = $this->subscriptionMapper->getToggleById($toggleId); // Adjust based on your data retrieval method

    if (!$toggle) {
        throw new Exception("No such toggle with ID: " . $toggleId);
    }

    
    try {
    $this->subscriptionMapper->subscribe($toggleId, $currentUserId);
    $this->view->setFlash(i18n("subscribed"));
    $this->view->redirect("toggle", "subscribed");
    }catch(ValidationException $ex) {
        $errors = $ex->getErrors();
        print_r($ex);
}
}


public function unsubscribe() {
    // Check if the user is logged in
    if (!$this->checkSession()) {
        throw new Exception("Not in session. Unsubscribe toggles requires login");
    }

    // Get the current user from the session or your authentication system
    $currentUserId = $_SESSION['user_id']; // Adjust this based on your actual session structure

    // Get the ID of the toggle to be deleted
    $toggleId = (int)$_GET["id"];
    
    // Check if a valid toggle ID was provided
    if (!$toggleId) {
        throw new Exception("Invalid toggle ID provided");
    }

    // Get the Toggle object from the database
    $toggle = $this->subscriptionMapper->getToggleById($toggleId); // Adjust based on your data retrieval method

    if (!$toggle) {
        throw new Exception("No such toggle with ID: " . $toggleId);
    }

    try {
    // Delete the Toggle object from the database
    $this->subscriptionMapper->unsubscribe($toggleId, $currentUserId);
    $this->view->setFlash(i18n("unsubscribed"));
    // After deleting the toggle, you can redirect to a suitable location.
    $this->view->redirect("toggle", "suscribed");
    }catch(ValidationException $ex) {
        $errors = $ex->getErrors();
        print_r($ex);
}
}


    private function checkSession(){
        if (!isset($_SESSION["user_id"])){
		    $this->view->render("users", "login");
            return false;
		}
        return true;
    }
}