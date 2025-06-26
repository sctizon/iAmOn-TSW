<?php
// file: model/User.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class User
*
* Represents a User in the blog
*
* @author lipido <lipido@gmail.com>
*/
class User {

	/**
	* The user name of the user
	* @var string
	*/
	private $username;

	/**
	* The password of the user
	* @var string
	*/
	private $passwd;

	/**
	* The email of the user
	* @var string
	*/
	private $email;

	/**
	* The constructor
	*
	* @param string $username The name of the user
	* @param string $passwd The password of the user
	* @param string $email The email of the user
	*/
	public function __construct($username=NULL, $passwd=NULL, $email=NULL) {
		$this->username = $username;
		$this->passwd = $passwd;
		$this->email = $email;
	}

	/**
	* Gets the username of this user
	*
	* @return string The username of this user
	*/
	public function getUsername() {
		return $this->username;
	}

	/**
	* Sets the username of this user
	*
	* @param string $username The username of this user
	* @return void
	*/
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	* Gets the password of this user
	*
	* @return string The password of this user
	*/
	public function getPasswd() {
		return $this->passwd;
	}
	/**
	* Sets the password of this user
	*
	* @param string $passwd The password of this user
	* @return void
	*/
	public function setPassword($passwd) {
		$this->passwd = $passwd;
	}

	/**
	* Gets the email of this user
	*
	* @return string The email of this user
	*/
	public function getEmail() {
		return $this->email;
	}

	/**
	* Sets the email of this user
	*
	* @param string $email The email of this user
	* @return void
	*/
	public function setEmail($email) {
		$this->email = $email;
	}


	/**
 * Checks if the current user instance is valid for registration
 *
 * @throws ValidationException if the instance is not valid
 */
public function checkIsValidForRegister() {
    $errors = array();

    // Check if the username is valid (at least 5 characters, no spaces)
    if (strlen($this->username) < 5 || strpos($this->username, ' ') !== false) {
        $errors["username"] = "Username must be at least 5 characters long and should not contain spaces";
    }

    // Check if the password is valid (at least 5 characters)
    if (strlen($this->passwd) < 5) {
        $errors["passwd"] = "Password must be at least 5 characters long";
    }

    // Check if the email is provided and, if so, validate it
    if (!empty($this->email)) {
        if (strlen($this->email) < 5 || !$this->validateEmail($this->email)) {
            $errors["email"] = "Invalid email address";
        }
    }

    // If there are errors, throw a ValidationException
    if (!empty($errors)) {
        throw new ValidationException($errors, "User is not valid for registration");
    }
}

	function validateEmail($email) {
		$pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
		if (preg_match($pattern, $email)) {
			return true;
		} else {
			return false;
		}
	}
	
}