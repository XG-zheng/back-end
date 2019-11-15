<?php
//连接数据库
include("connection.php");
$data = json_decode(file_get_contents('php://input',TURE));

$fileInfo = $_FILES["file"];//从前端获取图片文件
$path = "./pictures/";//图片存放的相对路径
$fileName = $fileInfo["name"];//图片名
$filePath = $fileInfo["tmp_name"];//图片上传时的临时路径
$dirPath = __DIR__;//此php程序存放的目录
$dir = str_replace('\\', '/', $dirPath);//将反斜杠转换为正斜杠
move_uploaded_file($filePath,$path.$fileName);//移动图片

$u_id = $data['$u_id'];//用户ID
$pic = "$dir"."/pictures/"."$fileName";//图片在数据库的存放形式(绝对路径)
$content = $data['$content'];//动态内容
$a_id = $data['$a_id'];//艾特的人

$sql = "INSERT INTO affairs(u_id,pic,num_comment,num_approve,content,a_id) VALUES('$u_id','$pic',0,0,'$content','$a_id')";
mysqli_query($conn,$sql);
//关闭连接
mysqli_close($conn);
?>