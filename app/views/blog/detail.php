<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title><?php echo $detail['title']; ?>-枫飞落叶之地</title>
    <link href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/css/global.css" rel="stylesheet"/>
</head>
<body>
<?php include __APP__.'/views/common/header.php';?>

<div class="container">
    <div class="row">
        <div class="col-lg-9 sp article">
            <h2><?php echo $detail['title']; ?></h2>
            <p><?php echo $detail['content']; ?></p>
        </div>
        <div class="col-lg-3">
            <div class="row">
                <div class="col-lg-11 col-lg-offset-1 sp">
                    <p>右侧边栏</p>
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