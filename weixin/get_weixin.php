<?php
require_once("config.php");
// 设置中国时区
date_default_timezone_set("PRC");

//获取今日星期几;
$week_day = date('w');

//获取现在的时刻;
$now_time = read_now(date('G'));

//获取数据库值班用户信息;
$user_arr = get_weixin($dbtable);

//匹配当前时刻的用户信息;
$today_user = array();
foreach ($user_arr as &$val){
    if (preg_match("/$week_day/i", $val['week'])) {
        if (preg_match("/$now_time/i", $val['banci'])) {
            $today_user[] = array(
                'name' => $val['name'],
                'weixin' => $val['weixin'],
            );
        }
    }
}

//获取值班状态用户信息;
function get_weixin($dbtable){
    global $conn;
    $user_arr = array();
    $sql = "SELECT * FROM $dbtable WHERE zhiban='1'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $user_arr[] = array(
                'name' => $row["name"],
                'weixin' => $row["weixin"],
                'week' => $row["week"],
                'banci' => $row["banci"],
            );
        }
        return $user_arr;
    }
}

//处理班次问题;
function read_now($now_time){
    if ($now_time >= 9 && $now_time < 17){
        $res = 0;
    }elseif ($now_time >= 17 && $now_time < 23){
        $res = 1;
    }else{
        $res = 2;
    }
    return $res;
}

?>

var weixin_arr = <?php echo json_encode($today_user); ?>;
var number = weixin_arr.length;
var index = Math.floor(Math.random()*number);
var weixin = weixin_arr[index]['weixin'];
var name = weixin_arr[index]['name'];
