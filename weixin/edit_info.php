<?php
require_once("config.php");
$id = $_GET['id'];
$user_info = get_user($id,$dbtable);

//获取全部用户信息;
function get_user($id,$dbtable){
    global $conn;
    $user_arr = array();
    $sql = "SELECT * FROM $dbtable WHERE id='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $user_arr['name'] = $row["name"];
            $user_arr['weixin'] = $row["weixin"];
            $user_arr['week'] = $row["week"];
            $user_arr['banci'] = $row["banci"];
            $user_arr['zhiban'] = $row["zhiban"];
        }
    }
    return $user_arr;
}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>修改信息</title>
    <link rel="shortcut icon"href="favicon.ico">
    <link href="zui/css/zui.min.css" rel="stylesheet">
    <style>
        .edit-info{
            width: 360px;
            margin: 20px auto 0;
            padding: 0 15px;
            border: 1px solid #93a1a1;
        }
        .form-group{
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="edit-info">
    <form class="form-group" method="post">
        <div class="form-group text-center">修改用户信息</div>
        <div class="form-group">
            <label>姓名</label>
            <input type="text" class="form-control" name="name" value="<?php echo $user_info['name']; ?>">
        </div>
        <div class="form-group">
            <label>微信号</label>
            <input type="text" class="form-control" name="weixin" value="<?php echo $user_info['weixin']; ?>">
        </div>
        <div class="form-group">
            <label>星期</label><br>
            <label class="checkbox-inline"><input type="checkbox" name="week" value="0">星期日</label>
            <label class="checkbox-inline"><input type="checkbox" name="week" value="1">星期一</label>
            <label class="checkbox-inline"><input type="checkbox" name="week" value="2">星期二</label>
            <label class="checkbox-inline"><input type="checkbox" name="week" value="3">星期三</label>
            <label class="checkbox-inline"><input type="checkbox" name="week" value="4">星期四</label>
            <label class="checkbox-inline"><input type="checkbox" name="week" value="5">星期五</label>
            <label class="checkbox-inline"><input type="checkbox" name="week" value="6">星期六</label>
        </div>
        <div class="form-group">
            <label>班次</label><br>
            <label class="checkbox-inline"><input type="checkbox" name="banci" value="0"> 早班</label>
            <label class="checkbox-inline"><input type="checkbox" name="banci" value="1"> 中班</label>
            <label class="checkbox-inline"><input type="checkbox" name="banci" value="2"> 晚班</label>
        </div>
        <div class="form-group">
            <label>是否值班</label><br>
            <div class="switch">
                <?php
                if ($user_info['zhiban'] == 1){
                    echo "<input type=\"checkbox\" checked name=\"zhiban\">";
                    echo "<label>开启</label>";
                }else{
                    echo "<input type=\"checkbox\" name=\"zhiban\">";
                    echo "<label>关闭</label>";
                }
                ?>
            </div>
        </div>
        <div class="form-group"><button type="submit" onclick="add_user()" class="btn btn-primary btn-block">立即提交</button></div>
        <div class="form-group"><a href="add.php" class="btn btn-success btn-block">返回列表</a></div>
    </form>
</div>

<script src="zui/js/jquery.min.js"></script>
<script src="zui/js/zui.lite.js"></script>
<script>
    function add_user() {
        var zhiban = 0;
        var name = $(":input[name='name']").val().trim();
        if (!name){
            return false;
        }
        var weixin = $(":input[name='weixin']").val().trim();
        if (!weixin){
            return false;
        }
        var week = $(":input[name='week']");
        week = re_box(week);
        if (!week){
            return false;
        }
        var banci = $(":input[name='banci']");
        banci = re_box(banci);
        if (!banci){
            return false;
        }
        var zhi = document.getElementsByName("zhiban");
        if (zhi[0].checked){
            zhiban = 1;
        }
        //数据封装进data对象;
        var data = {
            id: '<?php echo $id;?>',
            name: name,
            weixin: weixin,
            week: week,
            banci: banci,
            zhiban: zhiban
        }

        $.post("update_user.php",data,function (result) {
            alert(result);
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

    $(":input[name='zhiban']").on('click',function () {
            if ($(this)[0].checked){
                $(".switch>label").text("开启");
            }else{
                $(".switch>label").text("关闭");
            }
    });

    var weeks = "<?php echo $user_info['week'];?>";
    var bans = "<?php echo $user_info['banci'];?>";

    //把字符串分割成数组;
    function str_to_array(str) {
        var arrs = [];
        arrs = str.split("-"); //字符分割成数组;
        return arrs;
    }
    var week_arrs = str_to_array(weeks);
    var bans_arrs = str_to_array(bans);

    //写入被选中数据;
    function set_list(arrs,name){
        var list = $(":input[name="+name+"]");
        for(let i = 0; i < arrs.length; i++){
            list[arrs[i]].checked = true;
        }
    }
    set_list(week_arrs,'week');
    set_list(bans_arrs,'banci');
</script>
</body>
</html>
