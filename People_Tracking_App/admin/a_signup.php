<?php 
require_once('../header/header.php'); 
require_once('../database/db.php'); 

if(isset($_REQUEST['submit'])){ // PHP Signup Validation Starts
    $errorArray = array();
    $valid = TRUE;
   $email = $_REQUEST["email"];
   $name = $_REQUEST['fname'].' '.$_REQUEST['lname'];
   $password = $_REQUEST["password"];
   $repeat_password = $_REQUEST["cpassword"];


    //  Email Validation
    if(strlen($email)<=0){
        $emailHelp = "<small id='emailHelp' style='display:block;color:yellow;' class='form-text text-muted'>Make sure you fill correct Email Id...!</small>";
        array_push($errorArray,"email");
        $valid = false;
      }else if(strlen($email)>0){
        // Checking For Duplicate Email Exists
        $checkEmail = "SELECT email FROM admin WHERE email = '$email'";
        $result= mysqli_query($connection,$checkEmail);
        $emailCount = mysqli_num_rows($result);
        if($emailCount>0){
          array_push($errorArray,"email");
          $emailHelp = "<small id='emailHelp' style='display:block;color:yellow;' class='form-text text-muted'>This Email is already exists...!</small>";
          $valid = false;
        }
      }else{
        echo "Something Wrong";
      }


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

     // Inserting Data into DB
     if(count($errorArray)<=0 || $valid == true){
        $checkKey = "SELECT unique_key FROM admin ORDER BY unique_key DESC LIMIT 1";
        $keyResult = mysqli_query($connection,$checkKey);
        $unique_keyCount = mysqli_fetch_array($keyResult);
        if($unique_keyCount > 0){
            $value =$unique_keyCount['user_key'];
            $fetched_value = intval($value);
            $fetched_value = $fetched_value+1;
        }else{
           
            $fetched_value=100;
        }
        $admin_id = "ADM".$fetched_value;
        $encr_pwd = password_hash($password,PASSWORD_BCRYPT);
        $password = $encr_pwd;
        $email = strtolower($email);
        echo $email.$password.$name.$fetched_value.$admin_id;

        $insertAdmin = "INSERT INTO admin(email,name,password,unique_key,admin_id,level)
        VALUES('$email','$name','$password','$fetched_value','$admin_id',1)";
        $success = mysqli_query($connection,$insertAdmin);
        if ($success) {
          header("Location:".$Index);
      }else{
        echo "Please Enter Valid Details";
      }

     }

}
?>
            <div class="row signupForm" style="margin-top:150px">
                <div class="col-md-12 login-form-1" >
                    <h3>Admin</h3>
                    <form method="POST" action="<?php $_SERVER["PHP_SELF"]?>">
                        <div class="form-group">
                            <label for="firstname">First Name:</label>
                            <input type="text" id="firstname" name="fname" class="form-control" placeholder="First Name" required  />
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name:</label>
                            <input type="text" id="lastname" name="lname" class="form-control" placeholder="Last Name" required  />
                        </div>
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
                            <label for="lastname">Confirm Password</label>
                            <input type="password" id="cpassword" name="cpassword" class="form-control" placeholder="Confirm Password" required />
                            <?php if(isset($repeatPasswordHelp)){ echo $repeatPasswordHelp;}?>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btnSubmit" name="submit" value="Signup" />
                        </div>
                        <div class="form-group">
                            <a href="a_login.php" class="ForgetPwd">Login!</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php require_once('../header/footer.php'); ?>
