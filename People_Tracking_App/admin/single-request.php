<?php 
session_start();
require_once('../header/header.php');
  if(!isset($_SESSION['email'])){
    header("Location:".$Login);
  }

  if(!isset($_REQUEST['request'])){
    header("Location:".$Request);
  }else{
      $rfid = $_GET['request'];
      $getRf = "SELECT *
      FROM request 
      INNER JOIN user
      ON request.user_id = user.user_id
      WHERE `rfid` = '$rfid' ";
      
      $runQuery = mysqli_query($connection,$getRf);
      if($runQuery){
      $rf = mysqli_fetch_assoc($runQuery);
      $title = $rf['reason'];
      $desc = $rf['description'];
      $from = $rf['from_date'];
      $date = explode(" ",$from);
      $from = $date[0];      
      $to = $rf['to_date'];
      $date = explode(" ",$to);
      $to = $date[0];  
      $on =$rf['requested_on']; 
      $status = $rf['status'];
      $comments = $rf['comments'];
      $ftime=strtotime($from);
      $fmonth=date("F",$ftime);
      $fyear=date("Y",$ftime);
      $fdate = date("d-D",$ftime);

      $ttime=strtotime($to);
      $tmonth=date("F",$ttime);
      $tyear=date("Y",$ttime);
      $tdate = date("d-D",$ttime);

      $otime=strtotime($on);
      $omonth=date("F",$otime);
      $oyear=date("Y",$otime);
      $odate = date("d-D",$otime);

      $user = $rf['name'];
      $email = $rf['email'];
      $linkedid = $rf['linked_id'].'-'.$rf['linked_id_type'];
      }else{
        echo "<h1>Failed to fetch data</h1>";
      }
}

if(isset($_REQUEST['commentsubmit'])){
  $comments = $_REQUEST['comments'];
  $status  = $_REQUEST['status'];
  $rfid = $_REQUEST['request'];
  $updateRfStatus = "UPDATE request SET
    status = '$status',
    comments = '$comments'
    WHERE rfid = '$rfid'
  ";

$success = mysqli_query($connection,$updateRfStatus);
if ($success) {
echo "<div class='alert alert-success' role='alert'>
    Request Details Updated 
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}else{
echo $comments. $status . $rfid;
}
}

?>

    <!--=========== START BLOG SECTION ================-->       
    <section id="blogArchive">      
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="blog-breadcrumbs-area">
            <div class="container">
              <div class="blog-breadcrumbs-left">
                <h2>Request Details:<?= $_GET['request'] ?></h2>
              </div>
              <div class="blog-breadcrumbs-right">
                <ol class="breadcrumb">
                  <li>You are here</li>
                  <li><a href="#">Home</a></li>                  
                  <li class="active">Request Details</li>
                </ol>
              </div>
            </div>
          </div>
        </div>        
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="container">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <!-- Start Blog Archive Area -->
                <div class="blogArchive-area">
                  <div class="row">
                    <!-- Start Blog Content -->
                    <div class="col-md-12 col-sm-12">  
                      <div class="blog-content">
                        <!-- Start Single Blog -->
                        <div class="single-Blog">
                          <div class="single-blog-left">
                          <h4>Requested On:</h4>
                            <ul class="blog-comments-box">
                              <li><?= $omonth?> <h2><?= $odate?></h2><?= $oyear ?></li>
                            </ul>
                            <h4>Requested From:</h4>
                            <ul class="blog-comments-box">
                              <li><?= $fmonth?> <h2><?= $fdate?></h2><?= $fyear ?></li>
                            </ul>
                            <h4>Requested Upto:</h4>
                            <ul class="blog-comments-box">
                              <li><?= $tmonth?> <h2><?= $tdate?></h2><?= $tyear ?></li>
                            </ul>
                          </div>
                          <div class="single-blog-right">
                            <div class="blog-img">
                               <a href="docview.php?request=<?= $rfid ?>">Click to View Docs</a>
                                <span class="image-effect"></span>
                            </div>
                            <div class="blog-author">
                            </div>
                            <div class="blog-content blog-details">
                                <h2><?=strtoupper($title) ?></h2>                           
                                <p>
                                  <?= $desc?>
                                </p>
                              <h3>Details</h3> 
                              <table class="table">
  <thead>
    <tr>
      <th scope="col">#Sl.No</th>
      <th scope="col">RFID</th>
      <th scope="col">Title</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Linked ID</th>
      <th scope="col">Duration</th>
      <th scope="col">Comments</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td><?=$rfid ?></td>
      <td><?=$title ?></td>
      <td><?=$user ?></td>
      <td><?=$email ?></td>
      <td><?=$linkedid ?></td>
      <td><?= $from?> - <?= $to ?></td>
      <td><?= $comments ?></td>
      <td colspan=2>
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
    </tbody>
    </table>
    <h3>Comments to be Noted:</h3>
    <div id="respond">
                                <form id="commentform" method="POST" action="<?php $_SERVER["PHP_SELF"]?>">
                                  
                                  <p class="comment-form-comment">
                                    <label for="comment">Comment</label>
                                    <textarea required="required" aria-required="true" rows="8" cols="45" name="comments" ><?= $comments ?></textarea>
                                  </p>
   
                                  <p class="comment-form-comment">
                                    <label for="comment">Status</label>
                                    <select name="status">
                                      <option value="APPROVE">APPROVE</option>
                                      <option value="REJECT">REJECT</option>
                                      <option value="HOLD">HOLD</option>
                                    </select>
                                  </p>   
                                  <p class="form-submit">
                                    <input type="submit" value="Upload Comments" class="submit" name="commentsubmit">
                                    <input type="hidden" name="request" value="<?= $rfid ?>">
                                  </p>     
                                </form>
                              </div>                                   
</section>
    <?php require_once('../header/footer.php'); ?>
