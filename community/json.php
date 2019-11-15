<?php
//将code与查询的数据存到同一个数组中并转换为json格式输出
function json($code,$data)
{
	$result = array(
		'code' => $code,
		'data' => $data
	);
	echo json_encode($result,JSON_UNESCAPED_UNICODE);
}

?>