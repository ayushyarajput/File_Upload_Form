<?php
include 'db_config.php';
$target = "/var/www/html/form_webninjaz/user_files/";
$per_page=10;
$pg=0;
$current_page=1;
if(isset($_GET['pg'])){
	$pg=$_GET['pg'];
	if($pg<=0){
		$pg=0;
		$current_page=1;
	}else{
		$current_page=$pg;
		$pg--;
		$pg=$pg*$per_page;
	}
}
$record=mysqli_num_rows(mysqli_query($conn,"select * from upi"));
$pagi=ceil($record/$per_page);

$sql="select * from upi limit $pg,$per_page";
$res=mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style1.css">
</head>

<body>
<?php 
	if(mysqli_num_rows($res)>0)
    {

		echo "<table class='tabl'><th>User ID</th><th>First Name</th><th>Last Name</th><th>Phone Number</th><th>E-Mail</th><th>Files</th><th>Action</th>";
        while($row = mysqli_fetch_assoc($res)){
            $pid=$row['userid'];
            $fn = $row['file_name'];
            $a=explode(".",$fn);
            $b = $a[1];
            $ar = array('png', 'jpg', 'jpeg');
            echo "<tr><td>" . $row['userid'] . "</td><td>" . $row['fname'] . "</td><td>" . $row['lname'] . "</td><td>" . $row['phono'] . "</td><td>" . $row['mailid'] . "</td><td>";
            if(in_array($b,$ar)){echo '<a href="user_files/'.$fn.'"><img width="33px" src="user_files/'.$fn.'"></a></td><td>';}
            else{echo '<a href="download.php?path=user_files/'.$fn.'">' . $fn . '</a></td><td>';}
            echo '<a href="delete.php?userid='. $pid.'" onclick="return delete_confirm()">Delete</a> &nbsp &nbsp <a href="update.php?userid='. $pid . '" onclick="return update_confirm()">Update</a>';
            echo "</td></tr>";
        }
        echo"</table>";
	}
    else {echo "No records Found";}
    for($i=1;$i<=$pagi;$i++){
        if($current_page==$i){
            ?>
            <a><?php echo $i?></a>&nbsp&nbsp
        <?php }
        else{
            ?>
            <a href="?pg=<?php echo $i?>"><?php echo $i?></a>
            <?php
            }
        } ?>
    <script src="script1.js"></script>

</body>

</html>
