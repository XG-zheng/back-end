<?php
//连接数据库
include("connection.php");
include("json.php");
header('Content-Type:application/json');

$date = json_decode(file_get_contents('php://input',TURE));
$tag = $date['$tag'];//0表示广场,1表示关注,2表示个人
$u_id = $date['$u_id'];//当前用户的ID

$number = array();//user表中的ID
$response = array();//存放查询数据


if($tag===0)
{
	$sql = " SELECT id FROM user ";
    $result = mysqli_query($conn,$sql);
    while ($row = mysqli_fetch_array($result))
    	$number[] = $row;
    for($i=0;$i<5;$i++)
    {
        //从表user已有id中随机选择一个
    	$id = array_rand($number,1);
    	$id = $number["$id"]["id"];
        //删除已被选择的id
    	$key=array_search($id ,$number);
        array_splice($number,$key,1);
        //查询数据
    	$sql = " SELECT nickname,himg FROM user WHERE id = '$id' ";
    	$result = mysqli_query($conn,$sql);
    	while($row = mysqli_fetch_assoc($result))
        	$response[] = $row;

		$sql = " SELECT name FROM friend WHERE u_id = '$u_id' AND f_id = '$id' ";
		$result = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($result))
        	$response[] = $row;

		$sql = " SELECT time,pic,num_comment,num_approve,content,a_id FROM affairs WHERE u_id = '$id' ";
		$result = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($result))
        	$response[] = $row;
        //已有ID数量不足则退出循环
		if(count($number) === 0)
    	    break;
    }
}
/*if($tag===1)
{
	    $sql1 = " SELECT nickname,himg FROM user WHERE id = '$id' AND EXISTS
	              (SELECT * FROM friend WHERE u_id = '$u_id' AND f_id = 'id[$i]' )";
	    $sql2 = " SELECT name FROM friend WHERE u_id = '$u_id' AND f_id = '$id' ";
	    $sql3 = " SELECT time,pic,num_comment,num_approve,content,a_id FROM affairs WHERE u_id = '$id' ";
}
if($tag===2)
{
	    $sql1 = " SELECT nickname,himg FROM user WHERE id = '$id' ";
	    $sql2 = " SELECT name FROM friend WHERE u_id = '$u_id' AND f_id = '$id' ";
    	$sql3 = " SELECT time,pic,num_comment,num_approve,content,a_id FROM affairs WHERE u_id = '$id' ";
}*/
json(1,$response);
//关闭连接
mysqli_close($conn);
?>