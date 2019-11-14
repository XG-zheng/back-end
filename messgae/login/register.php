<?php
require_once("./tool.php");
header('Content-Type:text/html;Charset=utf-8');
header("Access-Control-Allow-Origin: *");


$data = file_get_contents('php://input');
$message = json_decode($data,true);

$message['mailbox'] = '1176011838@qq.com';
$message['nickname'] = 'tom';
$message['sex'] = 0;
$message['area'] = '福州';
$message['pet'] = '123';
$message['password'] = '13456';
$message['pic'] = 'https://www.achaonihao.com/pethome/login/pic/default.jpg';


$db = conn();
$sql = 'insert into user(password,email,sex,pet,nickname,area,himg) values(:password,:email,:sex,:pet,:nickname,:area,:himg) ';
$stmt = $db->prepare($sql);
$stmt->execute([':password'=>$message['password'],':email'=>$message['mailbox'],
			':sex'=>$message['sex'],':area'=>$message['area'],':himg'=>$message['pic']);










