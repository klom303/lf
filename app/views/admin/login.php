<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta name="keywords" content="枫飞落叶之地,楓飛落葉之地">
    <meta name="description" content="枫飞落叶之地,楓飛落葉之地">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Login-楓飛落葉之地</title>
    <link type="image/x-icon" href="/images/favicon.ico " rel="shortcut icon">
    <link href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/css/global.css" rel="stylesheet"/>
</head>
<body>
<?php include __APP__.'/views/common/header.php';?>

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 sp login">
            <div class="col-lg-8">
                <form class="form-horizontal login-form" role="form">
                    <input class="form-control input-lg" type="text" id="username" placeholder="帐号" />
                    <input class="form-control input-lg" type="password" id="password" placeholder="密码" />
                    <button type="button" id="login" class="btn btn-primary">登录</button>
                    <a>忘记密码？</a>
                </form>
            </div>
            <div class="col-lg-4">
                <span class="login-logo"><img src="/images/leaf.png" /></span>
            </div>
        </div>
    </div>
</div>

<?php include __APP__.'/views/common/footer.php';?>
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('#login').on('click',function () {
            login();
        });
        function login(){
            $.post(
                '/postLogin',
                {
                    username:$('#username').val(),
                    password:$('#password').val()
                },
                function(resp){
                    if(resp.status!=200){
                        alert(resp.message);
                        return false;
                    }
                    window.location.href='/';
                },
                'json'
            );
        }
    });
</script>
</body>
</html>