<?php
header('Content-Type:text/html;Charset=utf-8');
header("Access-Control-Allow-Origin: *");

$data = file_get_contents('php://input');
$message = json_decode($data,true);
/*
$message['userid'] = 1;//发消息人id
$message['title'] = '我这条狗真好看！';//动态内容
$message['iss_user_id'] = 2;//收消息人id
$message['type'] = 1;
$message['message'] = '没有我的好看!';
*/


	$db = conn();
	$sql = 'insert into unsend_affairs(type,send_id,receive_id,title,message) values(:type,:userid,:iss_user_id,:title,:message)';
	$stmt = $db->prepare($sql);
	$stmt->execute([':type'=>$message['type'],':userid'=>$message['userid'],'iss_user_id'=>$message['iss_user_id'],':title'=>$message['title'],':message'=>$message['message']]);
	
function  conn(){
	$dns = "mysql:host=47.95.255.31;dbname=pethome";
	return new PDO($dns, "root","123456");
}





