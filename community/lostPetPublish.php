<?php
//连接数据库
include("connection.php");
$data = json_decode(file_get_contents('php://input',TURE));
$u_id = $data['$u_id'];
$class = $data['$class'];
$breed = $data['$breed'];
$nickname = $data['$nickname'];
$mobile = $data['$mobile'];
$area = $data['$area'];
$characters = $data['$characters'] ;
$infos = $data['$infos'] ;

$fileInfo = $_FILES["file"];//从前端获取图片文件
$path = "./pictures/";//图片存放的相对路径
$fileName = $fileInfo["name"];//图片名
$filePath = $fileInfo["tmp_name"];//图片上传时的临时路径
$dirPath = __DIR__;//此程序存放的目录
$dir = str_replace('\\', '/', $dirPath);
move_uploaded_file($filePath,$path.$fileName);//移动图片
$himg = "$dir"."/pictures/"."$fileName";//图片在数据库的存放形式(绝对路径)

$sql = "INSERT INTO lostpet(u_id,class,breed,nickname,mobile,area,characters,infos,himg)
        VALUES('$u_id','$class','$breed','$nickname','$mobile','$area','$characters','$infos','$himg')";
mysqli_query($conn,$sql);
//关闭连接
mysqli_close($conn);
?>