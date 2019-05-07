<?php
require_once("config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $id = $_POST['id'];
    $sql = "DELETE FROM $dbtable WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "删除成功";
    } else {
        echo "删除失败";
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