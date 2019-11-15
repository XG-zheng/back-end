<?php
include("connection.php");//连接数据库
include("json.php");//格式转换
header('Content-Type:application/json');
$data = json_decode(file_get_contents('php://input',TURE));
$id = $data['$id'];//寻宠启示的ID

$response = array();
$sql = " SELECT class,breed,nickname,mobile,area,characters,infos,himg FROM lostpet WHERE id = '$id' ";
$result = mysqli_query($conn,$sql);
/*错误检查
    if(!$result)
	    die(mysqli_error($conn));
*/
//判断code取值
if(mysqli_num_rows($result)>0)
	$code = 1;
else
	$code = 0;//表示查询不到数据
//将查询的数据以关联数组的形式存放到response中
while($row = mysqli_fetch_assoc($result))
	$response[] = $row;
json($code,$response);
//关闭连接
mysqli_close($conn); 
?>