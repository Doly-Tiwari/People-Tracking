<?php 
session_start();
require_once('../header/header.php'); 
if(!isset($_SESSION['email'])){
    header("Location:".$Login);
  }
  
?>
  <!-- Requests Block -->
  <div class="row requestsBlock" style="margin-top:150px">
  <?php
      $getRequests = "SELECT * FROM request";
      $runQuery = mysqli_query($connection,$getRequests);
      if($runQuery){
        $count=0;
       while( $request = mysqli_fetch_assoc($runQuery)){ $count++; ?>
          <div class="col-sm-3">
        <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= $request['reason']?></h5>
            <p class="card-text"><?= $request['description']?></p>
            <a href="single-request.php?request=<?= $request['rfid']?>" class="btn btn-warning">Check Details</a>
        </div>
        </div>
    </div>
       <?php }
      }?>
</div>

    <!--=========== End Home Blog SECTION ================-->
<?php require_once('../header/footer.php'); ?>
