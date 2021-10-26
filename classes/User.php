<?php

include_once 'config/Database.php';


class User {

	private $db;
	private $result;


	public function __construct() {
		$dbconn   = new Database();
		$this->db = $dbconn->connect();
	}

// Method to log in existing user. Gets entered username from database. Matches the entered password with the stored hash password.
	public
	function logInUser() {
		$enteredUsername = $_POST['username'];
		$enteredPassword = $_POST['password'];
		$sql             = "SELECT * FROM users WHERE username='$enteredUsername';";
		$this->result    = $this->db->query( $sql );
		if ( $this->result != null ) {
			$row             = $this->result->fetchAll( PDO::FETCH_ASSOC );
			$stored_password = $row[0]["password"];
			$stored_token    = $row[0]["token"];
			if ( password_verify( $enteredPassword, $stored_password ) ) {
                echo "<script>document.write(localStorage.setItem('auth_token', '$stored_token'))
//				https://studenter.miun.se/~idgu2001/dt173g/projekt/public/
//http://localhost:8000/
                    window.location.replace('https://studenter.miun.se/~idgu2001/dt173g/projekt/public/')</script>";
			} else {
				echo "<p class='errormessage'>Fel användarnamn eller lösenord.</p>";
			}
		} else {
			echo "<p class='errormessage'>Det finns ingen användare registrerad med användarnamnet " . $enteredUsername . ".</p>";
		}
	}


// Method to create new user. Gets username and password from input fields and stores it in database. Password stores with a hash.
	public function createUser(): string {
		if ( $_POST['username'] == "" || ( $_POST['password'] ) == "" ) {
			return "<p class='errormessage'>Fyll i alla fält.</p>";
		} else {
			$enteredUsername = $_POST['username'];
			$sql             = "SELECT * FROM users WHERE username='$enteredUsername';";
			$password        = $_POST['password'];
			if ( $this->result == null ) {
				$token        = bin2hex( openssl_random_pseudo_bytes( 10 ) );
				$hashPassword = password_hash( $password, PASSWORD_DEFAULT );
				$query        = $this->db->prepare( "INSERT INTO users (username, password, token) VALUES
                    (:enteredusername, :hashpassword, :token)" );
				$query->execute( array(
					'enteredusername' => $enteredUsername,
					'hashpassword'    => $hashPassword,
					'token'           => $token
				) );

				return "";
			} else {
				return "<p class='errormessage'>Användaren finns redan. Har du glömt ditt lösenord? Synd för dig ..</p>";
			}
		}
	}
}