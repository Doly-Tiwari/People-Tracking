<?php 
require_once('../header/header.php'); 
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
    $checkLogin = "SELECT * FROM `admin` WHERE `email` = '$email'";
    $result = mysqli_query($connection,$checkLogin);
    $admin = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if($admin){
      $PASS_CHECK = password_verify($password,$admin['password']);
      if($PASS_CHECK){
        session_start();
        $_SESSION['email'] = $admin['email'];
        $_SESSION['adminID'] = $admin['admin_id'];
        $_SESSION['name'] = $admin['name'];
        header("Location:index.php");
      }else{
        $passwordHelp = "<small id='passwordHelp' style='display:block;color:yellow;' class='form-text text-muted'>Invalid Password for: ".$admin['email']."</small>";
      }
    }else{
      $emailHelp = "<small id='emailHelp' style='display:block;color:yellow;' class='form-text text-muted'>We have No admin with this email</small>";
    }
  }
  }

?>
            <div class="row signupForm" style="margin-top:150px">
                <div class="col-md-12 login-form-1" >
                    <h3>Sign In</h3>
                    <form method="POST" action="<?php $_SERVER["PHP_SELF"]?>">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email"  required />
                            <?php if(isset($emailHelp)){ echo $emailHelp;}?>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password"  required />
                            <?php if(isset($passwordHelp)){ echo $passwordHelp;}?>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="loginsubmit" class="btnSubmit" value="Login" />
                        </div>
                        <div class="form-group">
                            <a href="<?= $ForgotPassword?>" class="ForgetPwd">Forget Password?</a>
                            <a href="a_signup.php" class="ForgetPwd">Signup!</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php require_once('../header/footer.php'); ?>
