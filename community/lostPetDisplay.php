<?php
//连接数据库
include("connection.php");
include("json.php");
header('Content-Type:application/json');

$number = array();
$response = array();
$code = 1;
$sql = " SELECT id FROM lostpet ";
$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array($result))
	$number[] = $row;

for($i=0;$i<3;$i++)
{
	//从表lostpet已有id中随机选择一个
	$id = array_rand($number,1);
	$id = $number["$id"]["id"];
	//删除已被选择的id
	$key=array_search($id ,$number);
    array_splice($number,$key,1);

	$sql = "  SELECT id,area,breed,characters,himg FROM lostpet WHERE id = '$id' ";
    $result = mysqli_query($conn,$sql);
    if($code!=0 && mysqli_num_rows($result) > 0)
	    $code = 1;
    else
	    $code = 0;
    while($row = mysqli_fetch_assoc($result))
	    $response[] = $row;
	//若已有id数不足则退出循环
	if(count($number) === 0)
    	break;
}
json($code,$response);
//关闭连接
//mysqli_close($conn); 
?>