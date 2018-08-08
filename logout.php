<?php
session_start();

$_SESSION['email'] = false;

session_destroy();

header("Location: index.php");



?>