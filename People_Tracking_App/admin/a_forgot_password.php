<?php 
require_once('../header/uheader.php'); 
if(isset($_REQUEST['forgotsubmit'])){
    $errorArray = array();
      $valid = true;
  
    $email = $_REQUEST['email'];
  
    //Email validation
    if(strlen($email)<=0){
      $emailHelp = "<small id='emailHelp' style='display:block;color:yellow;' class='form-text text-muted'>Make sure you fill correct Email Id...!</small>";
      array_push($errorArray,"email");
      $valid = false;
    } 
  
    // Fetching User Data From DB
    if(count($errorArray)<=0 || $valid == true){
    $checkLogin = "SELECT * FROM `admin` WHERE `email` = '$email'";
    $result = mysqli_query($connection,$checkLogin);
    $user = mysqli_num_rows($result);
    if($user>0 && $user<2){
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $salt = substr(str_shuffle($str_result), 0, 4);
        $key = password_hash($salt,PASSWORD_BCRYPT);
        $setCount = "INSERT INTO pwdrecovery(email,expire_count,hash_key)
        VALUES('$email',1,'$key')";

        $RunQuery = mysqli_query($connection,$setCount);
        if($RunQuery){

            $to_email = $email;
            $subject = "Password Recovery";
            $body = '<div style="padding:0;margin:0;width:100%!important;background-color:#ffffff" bgcolor="#FFFFFF">
	<table width="100%" cellpadding="30" border="0" cellspacing="0">
		<tbody><tr>
			<td align="center" bgcolor="#eeeeee">
				<table width="660" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF" style="border-radius:6px">
					<tbody><tr>
						<td style="border-radius:5px">
							
							<table width="600" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF">
								<tbody><tr>
									<td align="center" id="m_2033986728234124451content-5" style="padding:40px 0">
									</td>
								</tr>
							</tbody></table>
							<table width="600" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF">
								<tbody><tr>
									<td align="center" style="padding-bottom:60px;font-size:14px;font-family:Helvetica,Arial,Verdana sans-serif" id="m_2033986728234124451content-5">
                                        <div>
											<table width="560" border="0" cellpadding="0" cellspacing="0">
												<tbody><tr>
													<td align="center" style="color:#32454c;font-family:Helvetica,Arial,Verdana sans-serif">
														<p style="font-size:20px;line-height:1.25;margin:0"><b>Please Click the below link for resetting Password</b></p>
														<p style="font-size:30px;line-height:1.71;margin:20px 0 40px 0"><a href='."http://localhost/People%20Tracking%20App/user/$ResetPassword?email=$email&key=$salt".'>Click To Reset The Password</a></p>
											        </td>
											    </tr>
											  
							</tbody></table>						
						</td>
					</tr>
				</tbody>
        </table>				
';
            $headers = "From:fsd68team@yahoo.com";
            $headers .= "CC: fsd68team@yahoo.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
          
            $sendMail = mail($to_email, $subject, $body, $headers);
            if ($sendMail) {
                $success = "Password Recovery Link successfully sent to $to_email...";
            } else {
                $fail = "Password Recovery Link sending failed...";
            }


        }else{
            echo "Crypting Error Raised Tray Again";
        }

    }else{
        echo("We didn't found email");
    }
   
  }
  }
?>
            <div class="row loginForm" style="margin-top:150px">
                <div class="col-md-12 login-form-1" >
                    <h3>Enter email to reset password</h3>
                    <form method="POST" action="<?php $_SERVER["PHP_SELF"]?>">
                        <div class="form-group">
                            <input type="text" name='email' class="form-control" placeholder="Your Email *"  />
                            <?php if(isset($emailHelp)){ echo $emailHelp;}?>
                          </div>
                        <div class="form-group">
                            <input type="submit" name="forgotsubmit" class="btnSubmit" value="Submit" />
                        </div>
                        <div class="form-group">
                            <a href="<?= $Login?>" class="ForgetPwd">Cancel!</a>
                        </div>
                    </form>
                </div>
            </div>
            <?php 
            if(isset($success)){
                echo "<h1>$success</h1>";
            }
            if(isset($fail)){
                echo "<h1>$fail</h1>";
            }

            ?>
        <?php require_once('../header/footer.php'); ?>
