<?php

session_start();

if($_GET['action'] == 'logout') {
		session_unset();
		session_destroy();
		header("Location:index.php");
    }
    
?>
