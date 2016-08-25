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
                    <li <?php if($nav=='Home') echo 'class="active"'; ?>><a href="/">Home</a></li>
                    <li <?php if($nav=='Blog') echo 'class="active"'; ?>><a href="/blog">Blog</a></li>
                    <li <?php if($nav=='Other') echo 'class="active"'; ?>><a href="/other">Other</a></li>
                    <li <?php if($nav=='Framework') echo 'class="active"'; ?>><a href="/frame">Framework</a></li>
                    <li <?php if($nav=='About') echo 'class="active"'; ?>><a href="/about">About</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>