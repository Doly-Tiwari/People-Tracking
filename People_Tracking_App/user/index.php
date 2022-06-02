<?php session_start();
require_once('../header/uheader.php'); 
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
      <th scope="col">Status</th>
      <th scope="col">Update</th>
    </tr>
  </thead>
  <tbody>
  <?php
      
      $userid = $_SESSION['userID'];
      $getRequests ="SELECT *
      FROM request 
      INNER JOIN user
      ON request.user_id = user.user_id
      WHERE request.user_id = '$userid' ";

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
       <td>
      <?php if($status == "PENDING" || $status == "HOLD"){ ?>
         <a href="<?= $UpdateRequest?>?reqID=<?= $request['rfid']?>" class="btn-warning" style="padding:0.5em;">Update</a></a><br> 
            <?php }?> 
      </td>
    </tr>
    <?php }
      }else{
        echo "<h1>No Request Data Available</h1>";
      }?>
  </tbody>
</table>
    </section>
    <!--=========== END SLIDER SECTION ================-->


  



   
    <!--=========== End Home Blog SECTION ================-->
<?php require_once('../header/footer.php'); ?>
