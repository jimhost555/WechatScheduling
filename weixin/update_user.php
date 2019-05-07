<?php
require_once("config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $id = post_input($_POST['id']);
    $name = post_input($_POST['name']);
    $weixin = post_input($_POST['weixin']);
    $week = post_input($_POST['week']);
    $banci = post_input($_POST['banci']);
    $zhiban = post_input($_POST['zhiban']);
    $sql = "UPDATE $dbtable SET name='$name', weixin='$weixin', week='$week', banci='$banci', zhiban='$zhiban' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "数据更新成功";
    } else {
        echo "数据更新失败";
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