<div class="header">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#example-navbar-collapse">
                    <span class="sr-only">切换导航</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">楓飛落葉之地</a>
            </div>
            <div class="collapse navbar-collapse" id="example-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li <?php if(isset($nav)&&$nav=='Home') echo 'class="active"'; ?>><a href="/">Home</a></li>
                    <li <?php if(isset($nav)&&$nav=='Blog') echo 'class="active"'; ?>><a href="/blog">Blog</a></li>
                    <li <?php if(isset($nav)&&$nav=='Other') echo 'class="active"'; ?>><a href="/other">Other</a></li>
                    <li <?php if(isset($nav)&&$nav=='Framework') echo 'class="active"'; ?>><a href="https://github.com/klom303/lf">Framework</a></li>
                    <li <?php if(isset($nav)&&$nav=='About') echo 'class="active"'; ?>><a href="/about">About</a></li>
                    <?php if($usr) {?>
                        <li <?php if(isset($nav)&&$nav=='Admin') echo 'class="active"'; ?>><a href="/manage">Manage</a></li>
                    <?php }?>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <?php if($usr){?>
                        <li><a href="javascript:void(0);"><span class="glyphicon glyphicon-user"></span> <?php echo $usr['username']; ?></a></li>
                        <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> 登出</a></li>
                    <?php }else{?>
                        <li><a href="/login"><span class="glyphicon glyphicon-log-in"></span> 登录</a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </nav>
</div>