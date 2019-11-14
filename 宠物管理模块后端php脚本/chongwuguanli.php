<!DOCTYPE html> 
<html> 
<body> 

<h1>My first PHP page</h1> 

<?php
//连接数据库
include("connection.php");
$id=;//自增id等于多少？
$type=;//0配对、1领养、2转让、3寄养


$sql = "SELECT breed,nickname,mobile,sex,himg FROM notice where type="$type" AND id="$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        $ =$row["breed"];
        $ =$row["nickname"];
        $ =$row["mobile"];
        $ =$row["sex"];
        $ =$row["himg"];
    }
} else {
    /*echo "0 结果";*/
}
$conn->close();
?>


</body> 
</html>