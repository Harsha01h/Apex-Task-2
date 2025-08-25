<?php
require_once 'config/session.php';

// Destroy session and redirect to home
session_destroy();
header('Location: index.php');
exit();
?>
