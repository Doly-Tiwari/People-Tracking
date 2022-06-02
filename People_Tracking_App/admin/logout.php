<?php 
session_start();
session_destroy();
include_once("../includes/adminRedirect.php");
header("Location:".$Login);
?>