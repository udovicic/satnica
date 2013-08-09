<?php
/** Managing user accounts
 *
 * Handles login, logout and user registration
 */
class UsersController extends Core\Controller
{

/**
 * Login request
 */
	function login()
	{
		$user = new Core\User;

		$this->set('title', 'Prijava korisnika');

		if ($user->isLoggedIn()) {
			// user allready logged ing
			header("location: " . SITE_URL);
		}

		if (isset($_POST['submit'])) { //login attempt
			$username = $_POST['username'];
			$password = $_POST['password'];

			if ($username == '' || $password == '') {
				$this->set('alert', 'Niste unjeli sva polja');
				return;
			}

			$user_info = $this->User->validate($username, sha1($password));
			if ($user_info == false) {
				$this->set('alert', 'Neispravni korisnički podaci');
				return;
			}

			// store user info
			$user->setLoggedin(true);
			$user->set('rate_id', $user_info['rate_id_fk']);
			$user->set('username', $username);

			// redirect to default page
			header("location: " . SITE_URL);
		}
	}

/**
 * Logout request
 */
	function logout()
	{
		$this->set('title', 'Odjava korisnika');
		session_destroy();
	}
	
}