<?php
header('Content-Type:text/html;Charset=utf-8');
header("Access-Control-Allow-Origin: *");


$data = file_get_contents('php://input');
$message = json_decode($data,true);
	
//$message['userid'] = 2;

	
	
	//获得消息
	$db = conn();
	$sql = 'select * from unsend_affairs where receive_id = :userid';
	$stmt = $db->prepare($sql);
	$stmt->execute([':userid'=>$message['userid']]);
	$res = $stmt->fetchAll();
	echo json_encode($res); 
	//删除消息
	$sql = 'delete from unsend_affairs where receive_id = :userid';
	$stmt = $db->prepare($sql);
	$stmt->execute([':userid'=>$message['userid']]);

function  conn(){
	$dns = "mysql:host=47.95.255.31;dbname=pethome";
	return new PDO($dns, "root","123456");
}



