<?php include 'db_config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    if (isset($_POST['submit'])){
        $target = "/var/www/html/form_webninjaz_second/user_files/";
        $id = $_GET['userid']; 
        $First_Name = $_POST['First_Name'];
        $Last_Name = $_POST['Last_Name'];
        $ph_no = $_POST['phono'];
        $mail_id = $_POST['mailid'];
        $sql = "SELECT * FROM `upi` where userid='$id'";
        $res=mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($res);
        $fn = $row['file_name'];
        $a=explode(".",$fn);
        $ext = $a[1];
        if($row){
            if($id==$row['userid']){
                $filename = $id.$First_Name.".".$ext;
                $sql = "UPDATE upi SET fname = '$First_Name', lname = '$Last_Name', phono = '$ph_no', file_name='$filename', mailid = '$mail_id' WHERE upi.userid = $id";
                $result = mysqli_query($conn,$sql);
                if($_FILES['file']['name']==""){ 
                    rename($target.$fn, $target.$filename);
            }
            }else{echo "<script>alert('User With same Mail or Phone already present Cannot Register')</script>";}
        }
        else{
            $sql = "UPDATE upi SET fname = '$First_Name', file_name='$filename', lname = '$Last_Name', phono = '$ph_no', mailid = '$mail_id' WHERE upi.userid = $id";
            $result = mysqli_query($conn,$sql);
            if($_FILES['file']['name']==""){ 
                    rename($target.$fn, $target.$filename);
            }
        }
        if($_FILES['file']['name']!=""){
            $upload=false;
            $allowed = array('gif', 'pdf', 'jpg', 'doc', 'jpeg', 'png');
            $fileup = $_FILES['file']['name'];
            $path = pathinfo($fileup);
            $ext = $path['extension'];
            if($_FILES['file']['size'] < 2097152){
                if (in_array($ext, $allowed)) {
                    $filename = $id.$First_Name.".".$ext;
                    unlink('user_files/'.$fn);//dlete file query
                    move_uploaded_file($_FILES['file']['tmp_name'],$target.$filename);
                    mysqli_query($conn,"UPDATE `upi` SET `file_name` = '$filename' WHERE `upi`.`userid` = '$id'");
                    
                }else{echo '<script>alert("allowed file types are onli .doc, .pdf, .jpg, .gif")</script>';}
            }else{echo '<script>alert("file should be less than 2mb")</script>';}
        }
    }
?>

<html>

<head>
    <title>Registration Form</title>
<link rel="stylesheet" href="style1.css">
</head>
<body>
<?php
$id = $_GET['userid']; 
$sql="SELECT * from upi where userid='$id'";
$result = mysqli_query($conn,$sql); 
$num = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);
    $fname = $row['fname'];
    $lname = $row['lname'];
    $phono = $row['phono'];
    $mailid = $row['mailid'];
    $fn = $row['file_name'];
    echo '<form class="info_form" name="f_form" action="" method="post" onsubmit="return formvalid();" enctype="multipart/form-data">';

    echo '<lable id="f_n"><strong> First Name : </strong></lable>';
    echo '<input type="text" id="First_Name" name="First_Name" value=' . $fname. '><br><br>';

    echo '<lable id="l_n"><strong>Last Name : </strong></lable>';
    echo '<input type="text" id="Last_Name" name="Last_Name" value=' . $lname. '><br><br>';

    echo '<lable id="p_n"><strong>Phone Number : </strong></lable>';
    echo '<input type="int" id="phono" name="phono" value=' . $phono. '><br><br>';

    echo '<lable id="e_m"><strong>E-Mail : </strong></lable>';
    echo '<input type="text" id="mailid" name="mailid" value=' . $mailid. '><br><br>';

    echo 'Existing File : <a href="user_files/'.$fn.'">' . $fn . '</a><br><br>';

    echo '<lable id="f_l"><strong>File Upload : </strong></lable>';
    echo '<input type="file" id="file" name="file" ><br><br>';

    echo '<input type="submit" name="submit" value="update">';
    echo '</form>';
?>
<a href="index.php">back</a>
    <script src="script1.js"></script>
</body>

</html>