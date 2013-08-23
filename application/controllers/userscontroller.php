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
			$user->set('user_id', $user_info['user_id']);
			$user->set('email', $user_info['email']);

			// redirect to default page
			header('location: ' . SITE_URL);
		}
	}

/**
 * Logout request
 */
	function logout()
	{
		session_destroy();
		header('location: ' . SITE_URL);
	}

/**
 * Change profile data
 */
	function profile()
	{
		$user = new Core\User;
		$this->set('title', 'Uređivanje korisničkog profila');

		if (isset($_POST['username']) == true) {
			// profile update request
			$info['username'] = $_POST['username'];
			$info['email'] = $_POST['email'];
			$info['rate_id'] = $_POST['rate'];
			if ($_POST['password'] != '') {
				$info['password'] = sha1($_POST['password']);
			}
			$info['user_id'] = $user->get('user_id');

			if ($info['username'] == '' || $info['email'] == '' || $info['rate_id'] == '') {
				// required fields not entered
				$this->set('notify', 'Korisničko ime i email su obvezni');
			} else {
				// make database update
				$result = $this->User->update($info);

				if ($result == false) {
					// update failed
					$this->set('notify', 'Greška prilikom spremanja');
				} else {
					// successful update
					// update user object
					$user->set('rate_id', $info['rate_id']);
					$user->set('username', $info['username']);
					$user->set('email', $info['email']);

					//set ui notification
					$this->set('notify', 'Izmjene spremljene');
				}
			}
		}

		// ui variables
		$rates = $this->User->getRateList();
		$this->set('rates', $rates);
		$this->set('username', $user->get('username'));
		$this->set('email', $user->get('email'));
		$this->set('rate_id', $user->get('rate_id'));
	}
	
}