<?php

require_once(__DIR__."/../core/PDOConnection.php");

class SubscriptionMapper {
    private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

    public function subscribe($toggleId, $currentUserId) {

        $stmt = $this->db->prepare("INSERT INTO subscriptions (user_id, toggle_id) VALUES (:currentUserId, :toggleId)");

        $stmt->bindParam(':toggleId', $toggleId, PDO::PARAM_INT);
        $stmt->bindParam(':currentUserId', $currentUserId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    

    public function unsubscribe($toggleId, $currentUserId) {
        $stmt = $this->db->prepare("DELETE FROM subscriptions WHERE user_id = :currentUserId AND toggle_id = :toggleId");

        $stmt->bindParam(':toggleId', $toggleId, PDO::PARAM_INT);
        $stmt->bindParam(':currentUserId', $currentUserId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getToggleById($toggleId) {
    
        // Define your database query to retrieve a toggle by ID
        $query = "SELECT * FROM toggles WHERE toggle_id = :toggle_id";
    
        // Prepare the query
        $stmt = $this->db->prepare($query);
    
        // Bind the toggle ID to the query
        $stmt->bindParam(':toggle_id', $toggleId, PDO::PARAM_INT);
    
        // Execute the query
        $stmt->execute();
    
        // Fetch the result as an object or an associative array, depending on your preference
        $toggle = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $toggle;
    }
    
}