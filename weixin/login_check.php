<?php
require_once("config.php");
$name = $pass = "";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = post_input($_POST["name"]);
    $pass = post_input($_POST["pass"]);
    $pass = md5($pass);

    if ($name == "admin" && $pass == "e10adc3949ba59abbe56e057f20f883e") {
        session_start();
        $_SESSION['user']=$name;
        header("location:add.php");
    } else {
        header("location:login.php");
    }
}
//过滤提交信息;
function post_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}