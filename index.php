<?php
include 'db_config.php';
if (isset($_POST['submit'])){
    $upload=false;
    $target = "/var/www/html/form_webninjaz_second/user_files/";
    $First_Name = $_POST['First_Name'];
    $Last_Name = $_POST['Last_Name'];
    $ph_no = $_POST['phono'];
    $mail_id = $_POST['mailid'];
    $sql = "SELECT mailid FROM `upi` where mailid='$mail_id'";
    $res=mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($res);
    if($_FILES['file']['name']!=""){
        $allowed = array('gif', 'pdf', 'jpg', 'doc', 'jpeg', 'png');
        $fileup = $_FILES['file']['name'];
        $path = pathinfo($fileup);
        $ext = $path['extension'];
        // echo filesize($_FILES['file']['tmp_name']);
        // echo $_FILES['file']['size']; die();
        if($_FILES['file']['size'] < 2000000 && $_FILES['file']['size'] > 1){
            if (in_array($ext, $allowed)) {
                if($row){
                    echo "<script>alert('User With same Mail or Phone already present Cannot Register');</script>";
                }
                else{
                    $sql = "INSERT INTO `upi` (`fname`, `lname`, `phono`, `mailid`) VALUES ('$First_Name', '$Last_Name', '$ph_no','$mail_id')";
                    $result = mysqli_query($conn,$sql);
                    $upload = true;
                }
                if($upload){
                    $sqla = "SELECT userid FROM upi ORDER BY userid DESC";
                    $resa=mysqli_query($conn,$sqla);
                    $rowa=mysqli_fetch_assoc($resa);
                    $ini = $rowa['userid'];
                    $filename = $ini.$First_Name.".".$ext;
                    $target = "/var/www/html/form_webninjaz_second/user_files/";
                    move_uploaded_file($_FILES['file']['tmp_name'],$target.$filename);
                    mysqli_query($conn,"UPDATE `upi` SET `file_name` = '$filename' WHERE `upi`.`userid` = '$ini'");
                    
                }
            }else{echo '<script>alert("allowed file types are onli .doc, .pdf, .jpg, .gif")</script>';}
        }else{echo '<script>alert("file should be less than 2mb")</script>';}
    }else{echo '<script>alert("Please select your Resume")</script>';}
}
?>
<html>
<head>
    <title>Registration Form</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <form class="info_form" name="f_form" action="" method="post" onsubmit="return formvalid();" enctype="multipart/form-data">
        <lable id="f_n"><strong> First Name : </strong></lable>
        <input type="text" id="First_Name" name="First_Name" value="<?php echo $_POST['First_Name'];?>"><br><br>
        <lable id="l_n"><strong>Last Name : </strong></lable>
        <input type="text" id="Last_Name" name="Last_Name" value="<?php echo $_POST['Last_Name'];?>"><br><br>
        <lable id="p_n"><strong>Phone Number : </strong></lable>
        <input type="int" id="phono" name="phono" value="<?php echo $_POST['phono'];?>"><br><br>
        <lable id="e_m"><strong>E-Mail : </strong></lable>
        <input type="text" id="mailid" name="mailid" value="<?php echo $_POST['mailid'];?>"><br><br>
        <lable id="f_l"><strong>File Upload : </strong></lable>
        <input type="file" id="file" name="file"><br><br>
        <input type="submit" name="submit" value="Submit">
        <input type="reset" value="reset">
    </form>
    <br>
    <br>
<?php include 'display.php';?>
<script src="script1.js"></script>
</body>
</html>