
<?php
//连接数据库
include("connection.php");
$type=;//0配对、1领养、2转让、3寄养


$sql = "SELECT breed,nickname,mobile,sex,himg FROM notice where type="$type" AND id="$id";
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
