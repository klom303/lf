<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta name="keywords" content="<?php echo $detail['title']; ?>,枫飞落叶之地,楓飛落葉之地">
    <meta name="description" content="<?php echo $detail['title']; ?>,枫飞落叶之地,楓飛落葉之地">
    <title><?php echo $detail['title']; ?>-楓飛落葉之地</title>
    <link type="image/x-icon" href="/images/favicon.ico " rel="shortcut icon">
    <link href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/css/global.css" rel="stylesheet"/>
</head>
<body>
<?php include __APP__.'/views/common/header.php';?>

<div class="container">
    <div class="row">
        <div class="col-lg-9 sp">
            <div class="article">
                <h2><?php echo $detail['title']; ?></h2>
                <hr>
                <p><?php echo $detail['content']; ?></p>
            </div>
            <!-- 多说评论框 start -->
            <div class="ds-thread" data-thread-key="<?php echo $detail['id']; ?>" data-title="<?php echo $detail['title']; ?>" data-url="/article?id=<?php echo $detail['id']; ?>"></div>
            <!-- 多说评论框 end -->
        </div>
        <div class="col-lg-3">
            <div class="row">
                <div class="col-lg-11 col-lg-offset-1 sp right-bar">
                    <h4>不知道这里放些什么</h4>
                    <p>感受中二的力量吧。</p>
                    <img class="cycle" src="<?php echo '/images/magic.png';?>" />
                </div>
                <div class="col-lg-11 col-lg-offset-1 sp right-bar">
                    <h4>随便丢点图</h4>
                    <img src="<?php echo '/images/character.jpg';?>" />
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __APP__.'/views/common/footer.php';?>
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<!-- 多说公共JS代码 start (一个网页只需插入一次) -->
<script type="text/javascript">
    var duoshuoQuery = {short_name:"yejialu"};
    (function() {
        var ds = document.createElement('script');
        ds.type = 'text/javascript';ds.async = true;
        ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
        ds.charset = 'UTF-8';
        (document.getElementsByTagName('head')[0]
        || document.getElementsByTagName('body')[0]).appendChild(ds);
    })();
</script>
<!-- 多说公共JS代码 end -->
</body>
</html>