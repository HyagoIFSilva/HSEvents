<?php

require_once __DIR__ . '/../config/config.php';

session_start();


$_SESSION = array();

session_destroy();


header('Location: ' . BASE_URL . 'login.php');

exit();
?>