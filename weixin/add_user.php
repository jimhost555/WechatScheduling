<?php
header("Content-type: text/html; charset=utf-8");
require_once("config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = post_input($_POST['name']);
    $weixin = post_input($_POST['weixin']);
    $week = post_input($_POST['week']);
    $banci = post_input($_POST['banci']);
    $zhiban = post_input($_POST['zhiban']);
    if (get_weixin($weixin,$dbtable)){
        echo "记录已存在";
        exit();
    }
    $sql = "INSERT INTO $dbtable (name, weixin, week, banci, zhiban)
VALUES ('$name', '$weixin', '$week', '$banci', '$zhiban')";
    if ($conn->query($sql) === TRUE) {
        echo "新记录插入成功";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}

//过滤提交信息;
function post_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function get_weixin($weixin,$dbtable){
    global $conn;
    $sql = "SELECT id FROM $dbtable where weixin='$weixin'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return true;
    }
    return false;
}