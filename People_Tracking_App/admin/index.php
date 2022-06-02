<?php 
session_start();
require_once('../header/header.php');
if(!isset($_SESSION['email'])){
  header("Location:".$Login);
}
?>
  <!--=========== BEGIN SLIDER SECTION ================-->
    <section id="requestsArea">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#Sl.No</th>
      <th scope="col">RFID</th>
      <th scope="col">Linked ID</th>
      <th scope="col">Date</th>
      <th scope="col">Deatils</th>
    </tr>
  </thead>
  <tbody>
  <?php
      $date_now = date("Y-m-d H:i:s");
      $adminid = $_SESSION['adminID'];
      $getRequests ="SELECT *
      FROM request 
      INNER JOIN user
      ON request.user_id = user.user_id
      ORDER BY request.id DESC 
     ";

      $runQuery = mysqli_query($connection,$getRequests);
      if($runQuery){
        $count=0;
       while($request = mysqli_fetch_assoc($runQuery)){ $count++;
        $status = $request['status'];
       ?>
    <tr>
      <th scope="row"><?= $count?></th>
      <td><a href="<?= $Request?>?request=<?= $request['rfid']?>"><?= $request['rfid']?></a></td>
      <td><?=  $request['linked_id'].'-'.$request['linked_id_type']?></td>
      <td><?=  $request['requested_on']?></td>
      <td>
      <?php if($status == "PENDING"){ ?>
        <span class="text-warning">PENDING</span><br> 
          <?php }else if($status == "HOLD"){ ?>
          <span class="text-primary">HOLD</span><br> 
          <?php }else if($status == "APPROVE"){ ?>
          <span class="text-success">APPROVED</span><br> 
          <?php }else if($status == "REJECT"){ ?>
          <span class="text-danger">REJECTED</span><br> 
          <?php }else{?>
            <span class="text-primary">UNKNOWN</span><br> 
            <?php }?>  
      </td>
    </tr>
    <?php }
      }else{
        echo "<h1>No Request Data Available</h1>";
      }?>
  </tbody>
</table>
</table>
    </section>
    <!--=========== END SLIDER SECTION ================-->

    <!--=========== BEGIN Top Feature SECTION ================-->
    <section id="topFeature">
      <div class="row">
        <!-- Start Single Top Feature -->
        <div class="col-lg-12 col-md-12">
          <div class="row">
            <div class="single-top-feature">
              <?php 
                $date_now = date('d-m-y');
                $getRequestsCount ="SELECT * FROM request WHERE requested_on = '$date_now' ";
          
                $runQuery = mysqli_query($connection,$getRequestsCount);
                $count = mysqli_num_rows($runQuery);
              ?>
              <h3>Today Request Count => <?= $count?></h3>
              <div class="readmore_area">
                <a href="<?= $Requests?>" data-hover="View All"><span>View All</span></a>
              </div>
            </div>
          </div>
        </div>
        <!-- End Single Top Feature -->
         
     

       
      </div>
    </section>
    <!--=========== END Top Feature SECTION ================-->

    <!--=========== BEGIN Service SECTION ================-->
   
    <!--=========== End Service SECTION ================-->

    <!--=========== BEGAIN Counter SECTION ================-->
    <section id="counterSection">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12">
            <div class="counter-area">
              <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="counter-box">
                <?php 
                $getRequestsCount ="SELECT * FROM request";
                $runQuery = mysqli_query($connection,$getRequestsCount);
                $count = mysqli_num_rows($runQuery);
              ?>
                  <div class="counter-no counter">
                    <?= $count?>
                  </div>
                  <div class="counter-label">Total Requests</div>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-6">
                 <div class="counter-box">
                 <?php 
                $getRequestsCount ="SELECT SUM(head_count) as HeadCount FROM request";
                $runQuery = mysqli_query($connection,$getRequestsCount);
                $row = mysqli_fetch_assoc($runQuery);
                $count = $row['HeadCount'];
              ?>
                  <div class="counter-no counter">
                  <?= $count?>
                  </div>
                  <div class="counter-label">Total Head Count</div>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-6">
                 <div class="counter-box">
                 <?php 
                $getRequestsCount ="SELECT * FROM request WHERE status = 'PENDING' OR status = 'HOLD' ";
          
                $runQuery = mysqli_query($connection,$getRequestsCount);
                $count = mysqli_num_rows($runQuery);
              ?>
                  <div class="counter-no counter">
                    <?= $count?>
                  </div>
                  <div class="counter-label">Open Requests</div>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-6">
                 <div class="counter-box">
                 <?php 
                $getRequestsCount ="SELECT * FROM request WHERE status = 'APPROVE' OR status = 'REJECT' ";
          
                $runQuery = mysqli_query($connection,$getRequestsCount);
                $count = mysqli_num_rows($runQuery);
              ?>
                  <div class="counter-no counter">
                    <?= $count?>
                  </div>
                  <div class="counter-label">Closed Requests</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--=========== End Counter SECTION ================-->




   
    <!--=========== End Home Blog SECTION ================-->
<?php require_once('../header/footer.php'); ?>
