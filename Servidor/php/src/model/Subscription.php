<?php
// file: model/Subscription.php

class Subscription {
    private $subscription_id;
    private $user_id;
    private $toggle_id;
    private $subscription_date;

    public function __construct() { }

    public function getSubscriptionId() {
        return $this->subscription_id;
    }

    public function setSubscriptionId($subscription_id) {
        $this->subscription_id = $subscription_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getToggleId() {
        return $this->toggle_id;
    }

    public function setToggleId($toggle_id) {
        $this->toggle_id = $toggle_id;
    }

    public function getSubscriptionDate() {
        return $this->subscription_date;
    }

    public function setSubscriptionDate($subscription_date) {
        $this->subscription_date = $subscription_date;
    }
}