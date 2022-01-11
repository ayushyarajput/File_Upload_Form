


<?php include 'db_config.php';

    if (isset($_POST['submit'])){
        $id = $_GET['userid']; 
        $First_Name = $_POST['First_Name'];
        $Last_Name = $_POST['Last_Name'];
        $ph_no = $_POST['phono'];
        $mail_id = $_POST['mailid'];

        $sql = "SELECT * FROM `upi` where mailid='$mail_id'";
        $res=mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($res);
        if($row){
            if($id==$row['userid']){
                $sql = "UPDATE upi SET fname = '$First_Name', lname = '$Last_Name', phono = '$ph_no', mailid = '$mail_id' WHERE upi.userid = $id";
                $result = mysqli_query($conn,$sql);
                if($result){
                // header("Location: index.php");
            }
            }else{echo "<script>alert('User With same Mail or Phone already present Cannot Register')</script>";}
        }
        else{
            $sql = "UPDATE upi SET fname = '$First_Name', lname = '$Last_Name', phono = '$ph_no', mailid = '$mail_id' WHERE upi.userid = $id";
            $result = mysqli_query($conn,$sql);
            if($result){
                header("Location: index.php");
            }
        }
    }
?>



<?php array_map('unlink', glob("some/dir/*.txt")); ?>









<?php
include 'db_config.php';
if (isset($_POST['submit'])){
    $upload=false;
    $target = "/var/www/html/form_webninjaz/user_files/";
    $First_Name = $_POST['First_Name'];
    $Last_Name = $_POST['Last_Name'];
    $ph_no = $_POST['phono'];
    $mail_id = $_POST['mailid'];

    if($_FILES['file']['name']!=""){
        if($_FILES['file']['size'] < 2097152){
            $allowed = array('gif', 'pdf', 'jpg', 'doc', 'jpeg', 'png');
            $fileup = $_FILES['file']['name'];
            $path = pathinfo($fileup);
            $ext = $path['extension'];
            if (in_array($ext, $allowed)) {
                $sql = "SELECT mailid FROM `upi` where mailid='$mail_id'";
                $res=mysqli_query($conn,$sql);
                $row = mysqli_fetch_assoc($res);
                if($row){
                    if($id==$row['userid']){
                        $sql = "UPDATE upi SET fname = '$First_Name', lname = '$Last_Name', phono = '$ph_no', mailid = '$mail_id' WHERE upi.userid = $id";
                        $result = mysqli_query($conn,$sql);
                        // if($result){header("Location: index.php");}
                    }else{echo "<script>alert('User With same Mail or Phone already present Cannot Register')</script>";}
                }
                else{
                    $sql = "UPDATE upi SET fname = '$First_Name', lname = '$Last_Name', phono = '$ph_no', mailid = '$mail_id' WHERE upi.userid = $id";
                    $result = mysqli_query($conn,$sql);
                    if($result){$upload = true;}
                }
                if($upload){
                    $ini=$row['userid'];
                    $filename = $ini.$First_Name.".".$ext;
                    move_uploaded_file($_FILES['file']['tmp_name'],$target.$filename);
                    $ins=mysqli_query($conn,"UPDATE `upi` SET `file_name` = '$filename' WHERE `upi`.`userid` = '$ini'");
                    if($ins){header("Location: index.php");}
                }
            }else{echo '<script>alert("allowed file types are onli .doc, .pdf, .jpg, .gif")</script>';}
        }else{echo '<script>alert("file should be less than 2mb")</script>';}
    }else{echo '<script>alert("Please select File")</script>';}
}
?>