<?php 
session_start();
session_destroy();
include_once("../includes/userRedirect.php");
header("Location:".$Login);
?>