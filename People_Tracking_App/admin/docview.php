<?php 
session_start();
require_once('../header/header.php');
if(!isset($_SESSION['email'])){
  header("Location:".$Login);
}
        $rfid =  $_REQUEST['request'];
        $path = "../uploads/".$rfid."/";
        
        // Test if string contains the word 
        if(strpos($path.$rfid, $rfid) == true){ 
            $images = glob($path."*.jpg");
            ?>
            <div class="row docBlock" style="margin-top:150px">
            <div class="col-sm-12 thumbnails">
                <h4><a href="<?=$Request?>?request=<?=$rfid?>">Back To Form</a></h4>
            <?php
            $count=1;
            foreach($images as $image) {
            echo '<img src="'.$image.'"  id="'.$count.'" onclick="changeImage('.$count.')" /><br />';
            $count++;    
            }       
            ?>
             </div>
            

        </div>
          
            <?php 
        } else{
            echo "Files Not Found!";
        }
    ?>
    
</body>
</html>