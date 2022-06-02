<?php 
session_start();
require_once('../header/header.php'); 
if(!isset($_SESSION['email'])){
    header("Location:".$Login);
  }
?>

    <!--=========== START BLOG SECTION ================-->       
<section id="blogArchive">      
               <div class='row'>
                   <div class='col-md-12'>
                   <div id="map"></div>
                   </div>
               </div>                  
</section>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" type="text/css" href="./style.css" />
    <script src="./js/hotspots.js"></script>
    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9YX_yrqfCbxmA6P5ohM6Vm4U3l53Sf8Y&callback=initMap&v=weekly"
      async
    ></script>
    <?php require_once('../header/footer.php'); ?>
