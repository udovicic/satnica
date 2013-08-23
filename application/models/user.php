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

/**
 * Return list of available rates
 *
 * @return array string list
 */
	function getRateList()
	{
		$result = $this->query('SELECT rate_id, name FROM rate');
		if ($result == false) {
			$result = array();
		}
		
		return $result;
	}

/**
 * Update user info in database
 *
 * @param array $info Array with user information
 * @return bool True on successful update
 */
	function update($info)
	{
		$sql = 'UPDATE user SET username=:username, email=:email, rate_id_fk=:rate_id';
		if (isset($info['password']) == true) {
			$sql .= ', password=:password';
		}
		$sql .= ' WHERE user_id=:user_id';

		$result = $this->query($sql, $info);
		return $result;
	}
}