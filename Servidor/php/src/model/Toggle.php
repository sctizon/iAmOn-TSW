<?php
// file: model/toggle.php

class Toggle {
    private $toggle_id;
    private $public_id;
    private $private_id;
    private $toggle_name;
    private $state;
    private $user_id;
    private $user_name;
    private $shutdown_date;
    private $turn_on_date;
    private $description;
    private $subscription_date;

    public function __construct() { }

    public function getToggleId(){
        return $this->toggle_id;
    }

    public function setToggleId($toggle_id){
        $this->toggle_id = $toggle_id;
    }

    public function getPublicId() {
        return $this->public_id;
    }

    public function getSubscriptionDate() {
        return $this->subscription_date;
    }

    public function setSubscriptionDate($subscription_date) {
        $this->subscription_date = $subscription_date;
    }

    public function setPublicId($public_id) {
        $this->public_id = $public_id;
    }

    public function getPrivateId() {
        return $this->private_id;
    }

    public function setPrivateId($private_id) {
        $this->private_id = $private_id;
    }

    public function getToggleName() {
        return $this->toggle_name;
    }

    public function setToggleName($toggle_name) {
        $this->toggle_name = $toggle_name;
    }

    public function getState() {
        return $this->state;
    }

    public function setState($newState) {
        $this->state = $newState;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getUsername() {
        return $this->user_name;
    }

    public function setUsername($user_name) {
        $this->user_name = $user_name;
    }

    public function getShutdownDate() {
        return $this->shutdown_date;
    }

    public function setShutdownDate($shutdown_date) {
        $this->shutdown_date = $shutdown_date;
    }

    public function getTurnOnDate() {
        return $this->turn_on_date;
    }

    public function setTurnOnDate($turn_on_date) {
        $this->turn_on_date = $turn_on_date;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function isValidToggle() {
        $errors = array();
		
        if(strlen($this->getToggleName()) < 5){
            $errors["toggle_name"] = "Toggle name must be at least 5 characters length";
        }

        if(strlen($this->getToggleName()) > 100){
            $errors["toggle_name"] = "Toggle name must have less than 100 characters";
        }

        if(!is_bool($this->getState())){
            $errors["state"] = "State must be boolean";
        }

        if($this->getState() && !$this->isDateTimeValid($this->getShutdownDate())){
            $errors["shutdown_date"] = "Shutdown date is not valid";
        }

        if(strlen($this->getDescription()) > 400){
            $errors["description"] = "Toggle description must have less than 100 characters";
        }

         // If there are errors, throw a ValidationException
        if (!empty($errors)) {
        throw new ValidationException($errors, "toggle is not valid for add");
    }
    }

    public function canTurnOn(){
        $errors = array();
		
        if(!$this->isDateTimeValid($this->getShutdownDate())){
            $errors["shutdown_date"] = "Shutdown date is not valid";
        }

        if (sizeof($errors) > 0){
			throw new ValidationException($errors, "Toggle is not valid");
		}
    }

    public function canTurnOff(){
        $errors = array();
		
        if (sizeof($errors) > 0){
			throw new ValidationException($errors, "Toggle is not valid");
		}
    }

    public function defaultShutdownDate() {
        $dateTime = new DateTime();
        $dateTime->add(new DateInterval('PT1H'));
        
        return $dateTime->format('Y-m-d H:i:s');
    }

    private function isDateTimeValid($dateTime) {
        try {
            $dateTime = new DateTime($dateTime);    
        } catch (Exception $e) {
            return false;
        }
        $actualDateTime = new DateTime();
        $maxDateTime = clone $actualDateTime;
        $maxDateTime->add(new DateInterval('PT2H'));
        
        if ($dateTime < $actualDateTime) return false;
        if ($dateTime > $maxDateTime) return false;
        
        return true;
    }
}
