<?php

class User extends Core\Model
{

/**
 * Validate user credentials
 *
 * @param string $username Username
 * @param string $password sha1 value of password
 * @return mixed false on invalid user credentials, user info on success
 */
	function validate($username, $password) {
		$arg = array(
			'usr' => $username,
			'pwd' => $password
		);

		$info = $this->query('SELECT * FROM user WHERE username=:usr AND password=:pwd', $arg);

		if ($this->numRows() == 0) {
			return false;
		} else {
			return $info[0];
		}
	}
}