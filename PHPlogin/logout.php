<?php
session_start();
if(isset($_SESSION['email']))
	unset($_SESSION['email']);
if(isset($_SESSION['password']))
	unset($_SESSION['password']);
echo "<p>Logged out</p>";
?>