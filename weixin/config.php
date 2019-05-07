<?php
$servername = "127.0.0.1";
$username = "root";
$password = "a54das";
$dbname = "baidu_jingjia";
$dbtable = "baidu_1";

// 创建连接
$conn = new mysqli($servername, $username, $password ,$dbname);

// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

/**
 * 设置对应参数;
 */
$weeks = array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
$banci = array("早班","中班","晚班");
?>