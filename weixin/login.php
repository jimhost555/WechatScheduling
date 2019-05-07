<html>
<head>
    <meta charset="utf-8">
    <title>修改微信号登录</title>
    <link rel="shortcut icon"href="favicon.ico">
    <link href="zui/css/zui.min.css" rel="stylesheet">
</head>
<body>
<style>
    .form-table{
        width: 300px;
        margin: 20px auto 0;
        padding: 20px 30px;
        border: 1px solid #f1f1f1;
        border-radius: 10px;
    }
</style>
<h1 class="text-center" style="padding-top: 150px;">微信号修改登录</h1>
<form class="form-table" action="login_check.php" method="post">
    <div class="row">
        <div class="col-xs-12">
            <input name="name" type="text" class="form-control" placeholder="用户名">
        </div>
        <div class="col-xs-12" style="padding-top: 15px;">
            <input type="password" class="form-control" name="pass" placeholder="密码">
        </div>
        <div class="col-xs-12" style="padding-top: 15px;">
            <button class="btn btn-block btn-primary" type="submit">立即登录</button>
        </div>
    </div>
</form>
</body>
</html>