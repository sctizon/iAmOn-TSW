<?php

require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__.'/../util/mail.php');

class ToggleMapper {
    private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

    public function save($toggle) {
        $query = "INSERT INTO toggles (public_id, private_id, toggle_name, toggle_state, shutdown_date, user_id, toggle_description) 
                  VALUES (:public_id, :private_id, :toggle_name, :toggle_state, :shutdown_date, :user_id, :toggle_description)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':public_id', $toggle->getPublicId(), PDO::PARAM_STR);
        $stmt->bindParam(':private_id', $toggle->getPrivateId(), PDO::PARAM_STR);
        $stmt->bindParam(':toggle_name', $toggle->getToggleName(), PDO::PARAM_STR);
        $stmt->bindParam(':toggle_state', $toggle->getState(), PDO::PARAM_BOOL);
        $stmt->bindParam(':shutdown_date', $toggle->getShutdownDate());
        $stmt->bindParam(':user_id', $toggle->getUserId(), PDO::PARAM_INT);
        $stmt->bindParam(':toggle_description', $toggle->getDescription(), PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function findAll($userID) {
        $query = "SELECT * FROM toggles, users WHERE toggles.user_id = users.user_id AND toggles.user_id = :userID";
        
        // Preparar la consulta
        $stmt = $this->db->prepare($query);
        
        // Vincular el valor de :userID al parámetro en la consulta
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        $toggles_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $toggles = array();
        
        foreach ($toggles_db as $toggle_db) {
            $toggle = new Toggle();

            if($toggle_db["shutdown_date"] != NULL) {
                $actual = new DateTime(); 
                $off = new DateTime($toggle_db["shutdown_date"]);
                $state = $actual < $off;
            } else {
                $state = false;
            }   
            

            $toggle->setToggleName($toggle_db["toggle_name"]);
            $toggle->setPrivateId($toggle_db["private_id"]);
            $toggle->setPublicId($toggle_db["public_id"]);
            $toggle->setState($state);
            $toggle->setShutdownDate($toggle_db["shutdown_date"]);
            $toggle->setDescription($toggle_db["toggle_description"]);
            $toggle->setToggleId($toggle_db["toggle_id"]);
            array_push($toggles, $toggle);
        }
        
        return $toggles;
    }
    
    
    
    public function findSuscribed($userID) {
        $query = "SELECT * FROM toggles, subscriptions, users WHERE toggles.toggle_id = subscriptions.toggle_id AND users.user_id = subscriptions.user_id AND subscriptions.user_id = :userID";
        
        // Preparar la consulta
        $stmt = $this->db->prepare($query);
        
        // Vincular el valor de :userID al parámetro en la consulta
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        $suscribedToggles_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $suscribedToggles = array();
        
        foreach ($suscribedToggles_db as $suscribedToggle_db) {
            $suscribedToggle = new Toggle();

            if($suscribedToggle_db["shutdown_date"] != NULL) {
                $actual = new DateTime(); 
                $off = new DateTime($suscribedToggle_db["shutdown_date"]);
                $state = $actual < $off;
            } else {
                $state = false;
            }   

            $suscribedToggle->setToggleName($suscribedToggle_db["toggle_name"]);
            $suscribedToggle->setPublicId($suscribedToggle_db["public_id"]);
            $suscribedToggle->setState($state);
            $suscribedToggle->setShutdownDate($suscribedToggle_db["shutdown_date"]);
            $suscribedToggle->setUsername($suscribedToggle_db["username"]);
            $suscribedToggle->setDescription($suscribedToggle_db["toggle_description"]);
            $suscribedToggle->setToggleId($suscribedToggle_db["toggle_id"]);
            $suscribedToggle->setTurnOnDate($suscribedToggle_db["turn_on_date"]);
            array_push($suscribedToggles, $suscribedToggle);
        }
        
        return $suscribedToggles;
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


    public function findByPublicOrPrivateURI($toggleURI) {
    
        $query = "SELECT * FROM toggles WHERE public_id = :toggleURI OR private_id = :toggleURI";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':toggleURI', $toggleURI);
        $stmt->execute();
    
        // Recupera el resultado de la consulta
        $toggleData= $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($toggleData) {
            $toggle = new Toggle();
            $toggle->setToggleName($toggleData["toggle_name"]);
            $toggle->setState($toggleData["toggle_state"]);
            $toggle->setTurnOnDate($toggleData["turn_on_date"]);
            $toggle->setDescription($toggleData["toggle_description"]);
            $toggle->setToggleId($toggleData["toggle_id"]);
            return $toggle;
        }
    
        return null;
    }


    public function isUriPublic($publicUri) {


        $query = "SELECT COUNT(*) FROM toggles WHERE public_id = :publicUri";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':publicUri', $publicUri);
        $stmt->execute();

        $count = $stmt->fetchColumn();

        return $count > 0; 
    }
    
    public function turnOnUser($toggle) {
        $query = "UPDATE toggles
            SET toggle_state = :toggle_state, shutdown_date = :shutdown_date, turn_on_date = :turn_on_date
            WHERE toggle_id = :toggle_id AND user_id = :user_id; ";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':toggle_id', $toggle->getToggleId(), PDO::PARAM_INT);
        $stmt->bindParam(':toggle_state', $toggle->getState(), PDO::PARAM_BOOL);
        $stmt->bindParam(':shutdown_date', $toggle->getShutdownDate());
        $stmt->bindParam(':user_id', $toggle->getUserId(), PDO::PARAM_INT);
        $stmt->bindParam(':turn_on_date', $toggle->getTurnOnDate());

        if ($stmt->execute()) {
            $this->send_mail($toggle->getToggleId());
            return true;
            
        } else {
            return false;
        }
    }

    private function send_mail($toggleId) {
        $stmt = $this->db->prepare("SELECT u.email FROM users u
        JOIN subscriptions s ON u.user_id = s.user_id
        WHERE s.toggle_id = :toggleId");

        // Asignar valores a los parámetros del prepared statement
        $stmt->bindParam(':toggleId', $toggleId, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Iterar sobre los resultados y mostrar los emails suscritos
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if($row["email"] != NULL) {
                send_mail($row["email"], "Notificacion IAMON", "El interruptor " . $toggleId . " ha sido encendido.");
            }
        }
    }

    public function turnOffUser($toggle) {
        $query = "UPDATE toggles
            SET toggle_state = :toggle_state, shutdown_date = :shutdown_date
            WHERE toggle_id = :toggle_id AND user_id = :user_id; ";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':toggle_id', $toggle->getToggleId(), PDO::PARAM_INT);
        $stmt->bindParam(':toggle_state', $toggle->getState(), PDO::PARAM_BOOL);
        $stmt->bindParam(':shutdown_date', $toggle->getShutdownDate());
        $stmt->bindParam(':user_id', $toggle->getUserId(), PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    

    public function delete($toggleId) {
        $query = "DELETE FROM toggles WHERE toggle_id = :toggleId";
        $stmt = $this->db->prepare($query);
    
        $stmt->bindParam(':toggleId', $toggleId, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


}