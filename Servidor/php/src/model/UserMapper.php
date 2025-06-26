<?php
// file: model/UserMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class UserMapper
*
* Database interface for User entities
*
* @author lipido <lipido@gmail.com>
*/
class UserMapper {

	/**
	* Reference to the PDO connection
	* @var PDO
	*/
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	/**
	* Saves a User into the database
	*
	* @param User $user The user to be saved
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function save($user) {
		$stmt = $this->db->prepare("INSERT INTO users (username, passwd, email) VALUES (?, ?, ?)");
		$stmt->execute(array($user->getUsername(), $user->getPasswd(),$user->getEmail()));
	}

	/**
	* Checks if a given username is already in the database
	*
	* @param string $username the username to check
	* @return boolean true if the username exists, false otherwise
	*/
	public function usernameExists($username) {
		$stmt = $this->db->prepare("SELECT count(username) FROM users where username=?");
		$stmt->execute(array($username));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	/**
	* Checks if a given email is already in the database
	*
	* @param string $email the username to check
	* @return boolean true if the email exists, false otherwise
	*/
	public function emailExists($email) {
		$stmt = $this->db->prepare("SELECT count(email) FROM users where email=?");
		$stmt->execute(array($email));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	/**
	* Checks if a given pair of username/password exists in the database
	*
	* @param string $username the username
	* @param string $passwd the password
	* @return boolean true the username/passwrod exists, false otherwise.
	*/
	public function isValidUser($username, $passwd) {
		$stmt = $this->db->prepare("SELECT count(username) FROM users where username=? and passwd=?");
		$stmt->execute(array($username, $passwd));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	/**
	* Checks if a given pair of email/password exists in the database
	*
	* @param string $email the email
	* @param string $passwd the password
	* @return boolean true the email/passwrod exists, false otherwise.
	*/
	public function isValidEmail($email, $passwd) {
		$stmt = $this->db->prepare("SELECT count(email) FROM users where email=? and passwd=?");
		$stmt->execute(array($email, $passwd));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	public function getUserIdByUsername($username) {
		$query = "SELECT user_id FROM users WHERE username = :username";
		
		// Preparar la consulta
		$stmt = $this->db->prepare($query);
		
		// Vincular el valor de :userID al parámetro en la consulta
		$stmt->bindParam(":username", $username);
		
		// Ejecutar la consulta
		$stmt->execute();
		
		// Recuperar el resultado de la consulta
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	
		if ($result) {
			return $result["user_id"]; // Cambiar "id" a "user_id" para que coincida con la columna de la base de datos
		} else {
			// Si no se encuentra el usuario, puedes manejar el error de alguna manera
			// Por ejemplo, lanzar una excepción, devolver un valor por defecto, etc.
			return null; // O cualquier otro valor adecuado en tu aplicación
		}
	}
	
	
}