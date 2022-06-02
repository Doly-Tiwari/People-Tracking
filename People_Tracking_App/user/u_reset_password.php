<?php 
require_once('../header/uheader.php'); 
        $email = $_REQUEST['email'];
        $key = $_REQUEST['key'];

if(isset($_REQUEST['resetsubmit'])){
    $errorArray = array();
      $valid = true;
  
    $password = $_REQUEST['password'];
    $repeat_password = $_REQUEST["cpassword"];
  
   //  Password Validation
   $uppercase = preg_match('@[A-Z]@',$password);
   $lowercase = preg_match('@[a-z]@',$password);
   $number = preg_match('@[0-9]@',$password);
   $specialletters = preg_match('@[^\w]@',$password);
   if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
    $passwordHelp = "<small id='passwordHelp' style='display:block;color:yellow;' class='form-text text-muted'>Make sure your password should be combination of 1 lowercase and 1 uppercase and 1 number and 1 any special character with length of 8 characters</small>";
    array_push($errorArray,"password");
    $valid = false;
  }
   if(strlen($repeat_password)<8){
    $repeatPasswordHelp = "<small id='repeatPasswordHelp' style='display:block;color:yellow;' class='form-text text-muted'>Make sure your password length more than 8 characters</small>";
    array_push($errorArray,"repeat");
    $valid = false;
  }if($password != $repeat_password){
    $repeatPasswordHelp = "<small id='repeatPasswordHelp' style='display:block;color:yellow;' class='form-text text-muted'>Make sure your both password and repeat password should be same</small>";
    array_push($errorArray,"samepass");
    $valid = false;
  }
    // Fetching User Data From DB
    if(count($errorArray)<=0 || $valid == true){
    $checkKey = "SELECT * FROM `pwdrecovery` WHERE `email` = '$email' AND `expire_count`= 1 ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($connection,$checkLogin);
    $user =  mysqli_fetch_array($result,MYSQLI_ASSOC);
        if($user){
            $HASH_CHECK = password_verify($salt,$user['hash_key']);
            if($HASH_CHECK){
                $encr_pwd = password_hash($password,PASSWORD_BCRYPT);
                $updateUser = "UPDATE user SET password = $encr_pwd where email = '$email'";
                $success = mysqli_query($connection,$updateUser);
                if ($success) {
                  header("Location:".$Login);
              }else{
                print_r(mysqli_error_list($connection));
              }
            }
        }
  }
  }
?>
            <div class="row loginForm" style="margin-top:150px">
                <div class="col-md-12 login-form-1" >
                    <h3>Enter email to reset password</h3>
                    <form method="POST" action="<?php $_SERVER["PHP_SELF"]?>">
                    <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password"  required />
                            <?php if(isset($passwordHelp)){ echo $passwordHelp;}?>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Confirm Password</label>
                            <input type="password" id="cpassword" name="cpassword" class="form-control" placeholder="Confirm Password" required />
                            <?php if(isset($repeatPasswordHelp)){ echo $repeatPasswordHelp;}?>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name='email' value="<?= $email?>">
                            <input type="hidden" name='key' value="<?= $key?>">
                            <input type="submit" name="resetsubmit" class="btnSubmit" value="Submit" />
                        </div>
                        <div class="form-group">
                            <a href="<?= $Login?>.php" class="ForgetPwd">Cancel!</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php require_once('../header/footer.php'); ?>
