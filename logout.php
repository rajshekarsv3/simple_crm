<?php
    if(!isset($_SESSION)){
	    session_start();
	}
    if(!empty($_SESSION['admin']))
    {
        $_SESSION['admin'] = '';
    }
    else if(!empty($_SESSION['user']))
    {
        $_SESSION['user'] = '';
    }
    session_destroy();
    header('Location: home.php');
?>