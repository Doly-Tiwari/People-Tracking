<?php 
require('../database/db.php');
require_once('../header/uheader.php'); 
if(isset($_REQUEST['loginsubmit'])){
    $errorArray = array();
      $valid = true;
  
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
  
    //Email validation
    if(strlen($email)<=0){
      $emailHelp = "<small id='emailHelp' style='display:block;color:yellow;' class='form-text text-muted'>Make sure you fill correct Email Id...!</small>";
      array_push($errorArray,"email");
      $valid = false;
    } if(strlen($password)<8){
      $passwordHelp = "<small id='passwordHelp' style='display:block;color:yellow;' class='form-text text-muted'>Make sure you fill password</small>";
      array_push($errorArray,"password");
      $valid = false;
    }
  
    // Fetching User Data From DB
    if(count($errorArray)<=0 || $valid == true){
    $checkLogin = "SELECT * FROM `user` WHERE `email` = '$email'";
    $result = mysqli_query($connection,$checkLogin);
    $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if($user){
      $PASS_CHECK = password_verify($password,$user['password']);
      if($PASS_CHECK){
        session_start();
        $_SESSION['email'] = $user['email'];
        $_SESSION['userID'] = $user['user_id'];
        $_SESSION['name'] = $user['name'];
        header("Location:".$Index);
      }else{
        $passwordHelp = "<small id='passwordHelp' style='display:block;color:yellow;' class='form-text text-muted'>Invalid Password for: ".$user['email']."</small>";
      }
    }else{
      $emailHelp = "<small id='emailHelp' style='display:block;color:yellow;' class='form-text text-muted'>We have No user with this email</small>";
    }
  }
  }
?>
            <div class="row loginForm" style="margin-top:150px">
                <div class="col-md-12 login-form-1" >
                    <h3>Sign In</h3>
                    <form method="POST" action="<?php $_SERVER["PHP_SELF"]?>">
                        <div class="form-group">
                            <input type="text" name='email' class="form-control" placeholder="Your Email *"  />
                            <?php if(isset($emailHelp)){ echo $emailHelp;}?>
                          </div>
                        <div class="form-group">
                            <input type="password" name='password' class="form-control" placeholder="Your Password *" />
                            <?php if(isset($passwordHelp)){ echo $passwordHelp;}?>

                          </div>
                        <div class="form-group">
                            <input type="submit" name="loginsubmit" class="btnSubmit" value="Login" />
                        </div>
                        <div class="form-group">
                            <a href="<?= $ForgotPassword?>" class="ForgetPwd">Forget Password?</a>
                            <a href="u_signup.php" class="ForgetPwd">Signup!</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php require_once('../header/footer.php'); ?>
