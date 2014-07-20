<?php
	$user = new User;
	$user->login($_GET['login'], $_GET['password']);
?>