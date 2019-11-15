<?php 
//连接数据库
include("connection.php");
$data = json_decode(file_get_contents('php://input',TURE));
$u_id = $data['$u_id'];//点赞用户ID
$d_id = $data['$d_id'];//被点赞动态ID
$flag = 0;//为0点赞数减1,为1点赞数加1
//点赞数更新函数
function num_approve($flag)
{
	global $conn,$d_id;//声明全局变量
	if($flag === 0)
	{
		$sql = " UPDATE affairs SET num_approve = num_approve-1 WHERE id = '$d_id' ";
	}
	else
		{
			$sql = " UPDATE affairs SET num_approve = num_approve+1 WHERE id = '$d_id' ";
		}
	mysqli_query($conn,$sql);
}
//查询该用户是否已经点赞过该动态
$sql = "SELECT * FROM approve WHERE u_id = '$u_id' AND d_id = '$d_id' ";
$result = mysqli_query($conn,$sql);
//是,则取消点赞
if(mysqli_num_rows($result)>0){
	$sql = " DELETE FROM approve WHERE u_id = '$u_id' AND d_id = '$d_id' ";
	mysqli_query($conn,$sql);
}
//否,则插入元组
else
{
    $sql = "INSERT INTO approve(u_id,d_id) VALUES('$u_id','$d_id')";
	mysqli_query($conn,$sql);
	$flag = 1;
}
//affair表中num_approve的增减
num_approve($flag);
//关闭连接
mysqli_close($conn);
?>