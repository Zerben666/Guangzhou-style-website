<?php
$conn = new mysqli("localhost","root","","gdgz");

if ( $conn -> connect_error ) {
	die("连接失败".connect_error);
}else{
	echo "连接数据库成功";
	$conn -> query("SET NAMES UTF8");
}
//这是更好的连接数据库的写法，可惜我掌握时这个项目已完成，也就没有再改
//本项目没有用到这个文件
?>