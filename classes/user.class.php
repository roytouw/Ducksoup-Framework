<?php
class User extends Base {
	private $params = Array();

	function test($id) {
		$params['id'] = 2;
		$params['email'] = "roytow@hotmail.com";
		$this->fetch_all('SELECT * FROM user', $params);
	}
}
?>