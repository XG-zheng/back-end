<?php
$servername = "47.95.255.31";
$username = "root";
$password = "123456";
$dbsname = "pethome";
//连接数据库
$conn = mysqli_connect($servername,$username,$password,$dbsname,3306);
//防止汉字乱码
$query="set names utf8";
$result=$conn->query($query);
//检测连接
if(!$conn)
	die(mysqli_connect_error());
?>