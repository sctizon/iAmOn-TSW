<?php
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Subscription.php");
require_once(__DIR__."/../model/SubscriptionMapper.php");

require_once(__DIR__."/BaseRest.php");

class SubscriptionRest extends BaseRest {    
    private $subscriptionMapper;

    public function __construct() {
        $this->subscriptionMapper = new SubscriptionMapper();
    }

    public function subscribe($toggleId, $currentUserId) {
        // Check if the user is logged in
        if (!$this->checkSession($currentUserId)) {
            // Return an error response or throw an exception
            return "Not in session. Subscribe toggles requires login.";
        }

        // Check if a valid toggle ID was provided
        if (!$toggleId) {
            // Return an error response or throw an exception
            return "Invalid toggle ID provided.";
        }

        try {
            $this->subscriptionMapper->subscribe($toggleId, $currentUserId);
            // Return a success message or HTTP status 200
            return "Toggle subscribed.";
        } catch (ValidationException $ex) {
            $errors = $ex->getErrors();
            // Handle validation errors, perhaps return a specific HTTP status code
            return "Validation error: " . implode(", ", $errors);
        }
    }

    public function unsubscribe($toggleId, $currentUserId) {
        // Check if the user is logged in
        if (!$this->checkSession($currentUserId)) {
            // Return an error response or throw an exception
            return "Not in session. Unsubscribe toggles requires login.";
        }

        // Check if a valid toggle ID was provided
        if (!$toggleId) {
            // Return an error response or throw an exception
            return "Invalid toggle ID provided.";
        }

        try {
            $this->subscriptionMapper->unsubscribe($toggleId, $currentUserId);
            // Return a success message or HTTP status 200
            return "Toggle unsubscribed.";
        } catch (ValidationException $ex) {
            $errors = $ex->getErrors();
            // Handle validation errors, perhaps return a specific HTTP status code
            return "Validation error: " . implode(", ", $errors);
        }
    }

    private function checkSession($currentUserId) {
        // Perform your session checks based on $currentUserId
        // Return true if the session is valid; otherwise, return false
        return isset($currentUserId);
    }
}

// URI-MAPPING for this Rest endpoint
$toggleRest = new SubscriptionRest();
URIDispatcher::getInstance()
->map("PUT",	"/subscribe/$1", array($toggleRest,"subscribe"))
->map("PUT",	"/subscribe/$1", array($toggleRest,"unsubscribe"));

