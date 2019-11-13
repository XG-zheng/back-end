<?php

	function  conn(){
	$dns = "mysql:host=47.95.255.31;dbname=pethome";
	return new PDO($dns, "root","123456");
	}
	
	$db = conn();
	//$sql = 'insert into unsend_affairs(type,send_id,receive_id,message) values(0,1,4,"can you hear me?")';
	//$sql = 'insert into unsend_affairs(type,send_id,receive_id,title) values(1,3,2,"我这条狗真好看！")';
	$sql = 'select * from unsend_affairs';
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$res = $stmt->fetchAll();
	echo json_encode($res); 
