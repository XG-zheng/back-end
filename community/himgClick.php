<?php
include("connection.php");//连接数据库
include("json.php");
header('Content-Type:application/json');
$data = json_decode(file_get_contents('php://input',TURE));
$u_id1 = $data['$u_id1'];//被点击用户的用户ID
$u_id2 = $data['$u_id2'];//当前用户ID

$sql = " SELECT himg,nickname,sex,age,area FROM user WHERE id = '$u_id1'";
$result = mysqli_query($conn,$sql);
/*错误检查
 if(!$result)
	die(mysqli_error($conn));
*/
$response = array();//返回查询数据的数组
//将查询的数据存至response
while($row = mysqli_fetch_assoc($result))
	$response[] = $row;
//为code赋值,0为出错,1为正常
if(mysqli_num_rows($result) > 0)
	$code = 1;
else
	$code = 0;
//判断当前用户是否对被点击用户进行备注
$sql = " SELECT name FROM friend WHERE u_id = '$u_id2' AND f_id = '$u_id1' ";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);
if( $row != NULL )
{
	$sql = "  SELECT name FROM  friend WHERE u_id = '$u_id2' AND f_id = $u_id1 ";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result))
	    $response[] = $row;
}
json($code,$response);
//关闭连接
mysqli_close($conn); 
 ?>