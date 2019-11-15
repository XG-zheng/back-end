<?php
//连接数据库
include("connection.php");

$data = json_decode(file_get_contents('php://input',TURE));
$u_id = $data['$u_id'];
$d_id = $data['d_id'];
$content = $data['$content'];
//插入评论相关数据
$sql = " INSERT INTO comment(u_id,d_id,content) VALUES('$u_id','$d_id','$content') ";
mysqli_query($conn,$sql);
//affair中num_comment增加
$sql = " UPDATE affairs SET num_comment = num_comment+1 WHERE id = '$d_id' ";
mysqli_query($conn,$sql);
//关闭连接
mysqli_close($conn);
?>