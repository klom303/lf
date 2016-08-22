<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta name="keywords" content="枫飞落叶之地,楓飛落葉之地">
    <meta name="description" content="枫飞落叶之地,楓飛落葉之地">
    <title>楓飛落葉之地</title>
    <link type="image/x-icon" href="/images/favicon.ico " rel="shortcut icon">
    <link href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/css/global.css" rel="stylesheet"/>
</head>
<body>
<?php include __APP__.'/views/common/header.php';?>

<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <div class="row">
                <?php if(empty($lists)){ ?>
                    <div class="col-lg-12 content-list sp">
                        目前还没有内容...
                    </div>
                <?php }else{?>
                <?php foreach ($lists as $article) {?>
                    <div class="col-lg-12 content-list sp">
                        <h2><a href="article?id=<?php echo $article['id']; ?>"><?php echo $article['title']; ?></a></h2>
                        <p><?php echo $article['description']; ?></p>
                        <hr>
                        <span><i class="glyphicon glyphicon-time"></i><?php echo $article['created_at'];?></span>
                        <span><i class="glyphicon glyphicon-eye-open"></i><?php echo $article['click_count'] ?></span>
                    </div>
                <?php } ?>
                    <div class="col-lg-12 content-list sp">
                        <?php echo $paginateStr; ?>
                    </div>
                <?php }?>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="row">
                <div class="col-lg-11 col-lg-offset-1 sp right-bar">
                    <h4>文章分类</h4>
                    <ul class="align-center">
                        <?php foreach ($typeList as $type) {?>
                        <li><a href="/blog?type=<?php echo $type['id'] ?>"><?php echo $type['name'] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-lg-11 col-lg-offset-1 sp right-bar">
                    <h4>点击排行</h4>
                    <ul>
                        <?php foreach ($clickRank as $item){ ?>
                        <li><a href="/article?id=<?php echo $item['id']?>"><?php echo $item['title']?></a></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __APP__.'/views/common/footer.php';?>
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>