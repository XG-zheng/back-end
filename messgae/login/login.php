<?php
header('Content-Type:text/html;Charset=utf-8');
header("Access-Control-Allow-Origin: *");


$data = file_get_contents('php://input');
$message = json_decode($data,true);
	
$message['email'] = '123456@qq.com';
$message['password'] = "132456";

$db = conn();
$sql = 'select password from user where email = :email';
$stmt = $db->prepare($sql);
$stmt->execute([':account'=>$message['account']]);
$res = $stmt->fetch();
if($res[0]!=$message['password']){
	echo 0;//密码错误
}else{
	echo 1;//登录成功
}

function  conn(){
	$dns = "mysql:host=47.95.255.31;dbname=pethome";
	return new PDO($dns, "root","123456");
}