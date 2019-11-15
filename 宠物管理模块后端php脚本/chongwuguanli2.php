<!DOCTYPE html> 
<html> 
<body> 

<h1>My first PHP page</h1> 

<?php
//连接数据库
include("connection.php");
$id=;//自增id等于多少？
$type=;//0配对、1领养、2转让、3寄养

$himg=$_GET['himg'];
$P_class=
$breed=
$nickname=
$age=
$sex=
$mobile=
$supplement=
$sql = " INSERT INTO notice(himg,P_class,breed,nickname,age,sex,mobile,supplement) VALUES('$himg','$P_class','$breed','$nickname','$age','$sex','$mobile','$supplement') ";

mysqli_query($conn,$sql);
//affair中num_comment增加


$conn->close();
?>


</body> 
</html>