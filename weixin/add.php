<?php
require_once("config.php");
session_start();
$user = $_SESSION['user'];
if(!($user == "admin")){
    header("location:login.php");
}

//获取全部用户信息;
function get_info($dbtable){
    global $conn;
    $user_arr = array();
    $sql = "SELECT * FROM $dbtable ORDER BY time DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $user_arr[] = array(
                'id' =>$row['id'],
                'name' => $row["name"],
                'weixin' => $row["weixin"],
                'week' => $row["week"],
                'banci' => $row["banci"],
                'zhiban' => $row["zhiban"]
            );
        }
    }
    foreach ($user_arr as &$val){
        $val['week'] = reset_week($val['week']);
        $val['banci'] = reset_banci($val['banci']);
        $val['zhiban'] = $val['zhiban'] ? "<span class=\"label label-success\">值班</span>" : "<span class=\"label label-danger\">不值班</span>";
    }
    return $user_arr;
}

function reset_week($arr){
    $arr = explode("-",$arr);
    foreach ($arr as &$val)
    {
        switch ($val){
            case 0:
                $val = "星期日";
                break;
            case 1:
                $val = "星期一";
                break;
            case 2:
                $val = "星期二";
                break;
            case 3:
                $val = "星期三";
                break;
            case 4:
                $val = "星期四";
                break;
            case 5:
                $val = "星期五";
                break;
            case 6:
                $val = "星期六";
                break;
        }
    }
    return implode(' | ',$arr);
}

function reset_banci($arr){
    $arr = explode("-",$arr);
    foreach ($arr as &$val)
    {
        switch ($val){
            case 0:
                $val = "早班";
                break;
            case 1:
                $val = "中班";
                break;
            case 2:
                $val = "晚班";
                break;
        }
    }
    return implode(' | ',$arr);
}

$user_info = get_info($dbtable);
?>
<html>
<head>
    <meta charset="utf-8">
    <title>添加修改微信号</title>
    <link rel="shortcut icon"href="favicon.ico">
    <link href="zui/css/zui.min.css" rel="stylesheet">
</head>
<body>
<style>
    .form-table{
        width: 300px;
        margin: 0 auto;
        padding-top: 200px;
    }
    .form-table textarea{
        width: 100%;
        height: 150px;
    }
    .form-table .input-control{
        padding-top: 20px;
    }
    #tishi{
        display: none;
    }
    .table{
        width: 96%;
        margin: 20px auto 0;
    }
    .panel{
        width: 800px;
        margin-top: 20px;
        margin-left: 20px;
    }
    .alert{
        width: 200px;
        margin: 20px auto 0;
    }
</style>

<div class="panel">
    <div class="panel-heading">
        参数说明
    </div>
    <div class="panel-body">
        <p>班次说明：早班（09:00—17:00）中班（17:00—23:00）晚班（23:00—09:00）</p>
    </div>
</div>

<div class="alert alert-warning" style="display: none;">
    <button type="button" onclick="warning_hide()" class="close">×</button>
    <p class="val text-center"></p>
</div>
<div class="alert alert-success" style="display: none;">
    <button type="button" onclick="success_hide()" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <p class="text-center">插入成功</p>
</div>
<table class="table form-group">
    <thead>
    <tr>
        <th>姓名</th>
        <th>微信号</th>
        <th>星期</th>
        <th>班次</th>
        <th>是否值班</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><input type="text" class="form-control form-focus" placeholder="姓名" name="name"></td>
        <td><input type="text" class="form-control form-focus" placeholder="微信号" name="weixin"></td>
        <td>
            <div class="checkbox">
                <?php
                    foreach ($weeks as $k=>$val){
                        echo '<label class="checkbox-inline"><input type="checkbox" name="week" value="'.$k.'">'.$val.'</label>';
                    }
                ?>
            </div>
        </td>

        <td>
            <div class="checkbox">
                <?php
                    foreach ($banci as $k=>$val){
                        echo '<label class="checkbox-inline"><input type="checkbox" name="banci" value="'.$k.'">'.$val.'</label>';
                    }
                ?>
            </div>
        </td>
        <td>
            <div class="switch">
                <input type="checkbox" name="zhiban">
                <label>开启值班</label>
            </div>
        </td>
        <td><button onclick="add_user()" class="btn btn-primary" type="button">立即添加</button></td>
    </tr>
    <?php
    foreach ($user_info as $key=>$value)
    {
        echo "<tr><td>".$value['name']."<td>".$value['weixin']."<td>".$value['week']."<td>".$value['banci']."<td>".$value['zhiban']."<td><button class=\"btn btn-info\" onclick=\"edit_info(".$value['id'].")\" type=\"button\">修改</button> <button class=\"btn btn-warning\" type=\"button\" data-toggle=\"modal\" data-target=\"#myModal\" onclick=\"set_id(".$value['id'].")\">删除</button></td></td></td></td></td></td></tr>";
    }
    ?>
    </tbody>
</table>
<a href="loginout.php" class="btn btn-warning" type="button" onclick="loginout();" style="margin: 20px 0 0 50px;">退出登录</a>
<!-- 对话框HTML -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <p>确定要删除 <span id="set_id" style="color: red;"></span> 这条数据吗？</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" onclick="delete_user()">确定</button>
            </div>
        </div>
    </div>
</div>

<script src="zui/js/jquery.min.js"></script>
<script src="zui/js/zui.lite.js"></script>
<script>
    function add_user() {
        var zhiban = 0;
        var name = $(":input[name='name']").val().trim();
        if (!name){
            warning("姓名");
            return false;
        }
        var weixin = $(":input[name='weixin']").val().trim();
        if (!weixin){
            warning("微信号");
            return false;
        }
        var week = document.getElementsByName("week");
        week = re_box(week);
        if (!week){
            warning("星期");
            return false;
        }
        var banci = document.getElementsByName("banci");
        banci = re_box(banci);
        if (!banci){
            warning("班次");
            return false;
        }
        var zhi = document.getElementsByName("zhiban");
        if (zhi[0].checked){
            zhiban = 1;
        }
        //数据封装进data对象;
        var data = {
            name: name,
            weixin: weixin,
            week: week,
            banci: banci,
            zhiban: zhiban
        }

        $.post("add_user.php",data,function (result) {
            success(result);
        });
    }

    //处理checkbox选中元素值并拼接为字符串;
    function re_box(s) {
        var s2 = "";
        for( var i = 0; i < s.length; i++ )
        {
            if ( s[i].checked ){
                s2 += s[i].value + "-";
            }
        }
        s2 = s2.substr(0,s2.length-1);
        return s2;
    }

    //提示;
    function warning(val) {
        $(".alert-warning>p").text(val+"必需！");
        $(".alert-warning").show();
        return false;
    }
    function warning_hide() {
        $(".alert-warning").hide();
        return false;
    }
    //插入成功提示;
    function success(val) {
        $(".alert-success>p").text(val);
        $(".alert-success").show();
        setTimeout(reload,1500);
    }
    function success_hide() {
        $(".alert-success").hide();
        return false;
    }
    
    function reload() {
        window.location.reload();
        return false;
    }

    //编辑数据;
    function edit_info(index) {
        window.location.href = "edit_info.php?id="+index;
    }

    //设置id值;
    function set_id(id) {
        $("#set_id").text(id);
        return false;
    }

    //删除数据;
    function delete_user() {
        var id = $("#set_id").text();
        $('#myModal').modal('hide');
        $.post("delete.php",{id:id},function (result) {
            alert(result);
            window.location.reload();
        });
    }
</script>
</body>
</html>