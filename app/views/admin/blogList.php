<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta name="keywords" content="枫飞落叶之地,楓飛落葉之地">
    <meta name="description" content="枫飞落叶之地,楓飛落葉之地">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>后台-楓飛落葉之地</title>
    <link type="image/x-icon" href="/images/favicon.ico " rel="shortcut icon">
    <link href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/css/global.css" rel="stylesheet"/>
</head>
<body>
<?php include __APP__.'/views/common/header.php';?>

<div class="container">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 sp blog-list">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th width="50%">标题</th>
                        <th>分类</th>
                        <th>日期</th>
                        <th>操作</th></tr>
                    </thead>
                    <tbody>
                    <?php foreach ($lists as $item){ ?>
                        <tr>
                            <td>
                                <a target="_blank" href="/article?id=<?php echo $item['id']; ?>"><?php echo $item['title']?></a>
                            </td>
                            <td>
                                <?php echo $item['name']; ?>
                            </td>
                            <td>
                                <?php echo $item['created_at']?>
                            </td>
                            <td>
                                <button data-id="<?php echo $item['id']; ?>" type="button" class="btn btn-primary edit">编辑</button>
                                <button data-id="<?php echo $item['id']; ?>" type="button" class="btn btn-danger delete">删除</button>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
            <?php if($paginateStr){ ?>
                    <?php echo $paginateStr; ?>
            <?php }?>
        </div>
    </div>
</div>

<?php include __APP__.'/views/common/footer.php';?>
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('.delete').on('click',function(){
           if(confirm('是否确认删除?')){
               $.post(
                   '/deleteArticle',
                   {id:$(this).attr('data-id')},
                   function(resp){
                       if(resp.status!=200){
                           alert(resp.message);
                           return false;
                       }
                       window.location.reload();
                   },
                   'json');
           }
        });

        $('.edit').on('click',function(){
            window.location.href='/editArticle?id='+$(this).attr('data-id');
        });
    });
</script>
</body>
</html>