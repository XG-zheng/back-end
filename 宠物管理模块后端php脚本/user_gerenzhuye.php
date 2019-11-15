
<?php
//连接数据库
include("connection.php");
header('Content-Type:application/json');
$account=123456;//账号等于多少？
$sql = "SELECT nickname,sex,age,area FROM user where account='123456'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    //echo "0 结果";
}

if(mysqli_num_rows($result)>0)
{
    $code=1;
}
else{
    $code=0;
}
$json = json_encode(array(
    "code"=>$code,
    "data"=>$data
),JSON_UNESCAPED_UNICODE);

//转换成字符串JSON
echo($json);

$conn->close();
?>

