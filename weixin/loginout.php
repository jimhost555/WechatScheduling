<?php
session_start();
unset($_SESSION['user']);
?>
<div style="text-align: center;">
    <div id="time" style="font-size: 2em;">3</div>
    <div class="time-title">退出成功，3秒后跳转！</div>
</div>
<script>
    var time = document.getElementById("time");
    var number = 2;
    setInterval(retime,1000);
    function retime(){
        if (number > 0){
            time.innerText = number;
            number--;
        }else{
            window.location.href = "login.php";
        }
    }
</script>