<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta name="keywords" content="枫飞落叶之地,楓飛落葉之地">
    <meta name="description" content="枫飞落叶之地,楓飛落葉之地">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>编辑-楓飛落葉之地</title>
    <link type="image/x-icon" href="/images/favicon.ico " rel="shortcut icon">
    <link href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="http://oclr05hx7.bkt.clouddn.com/markdown/css/editormd.css" rel="stylesheet"/>
    <link href="/css/global.css" rel="stylesheet"/>
</head>
<body>
<?php include __APP__.'/views/common/header.php';?>

<div class="container">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 blog-list sp">
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="title" class="col-lg-1  control-label">标题</label>
                    <div class="col-lg-11">
                        <input class="form-control" id="title" type="text" value="<?php echo $article['title']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="type" class="col-lg-1 control-label">分类</label>
                    <div class="col-lg-11">
                        <select id="type" class="form-control">
                            <option value="0">请选择...</option>
                            <?php foreach ($typeList as $typeItem) {?>
                                <option <?php if($typeItem['id']==$article['type']) echo 'selected="selected"'; ?>
                                    value="<?php echo $typeItem['id']; ?>">
                                    <?php echo $typeItem['name']; ?>
                                </option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-lg-1 control-label">摘要</label>
                    <div class="col-lg-11">
                        <textarea class="form-control" id="description"><?php echo $article['description'];?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="content" class="col-lg-1 control-label">正文</label>
                    <div class="col-lg-11" id="editormd">
                        <textarea rows="20" class="form-control" id="content"><?php echo $article['content'];?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <button id="edit" type="button" class="btn btn-success col-lg-offset-4">修改</button>
                </div>
            </form>
        </div>
    </div>
</div>
<input type="hidden" id="hidId" value="<?php echo $article['id'];?>" />
<?php include __APP__.'/views/common/footer.php';?>
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://oclr05hx7.bkt.clouddn.com/markdown/editormd.min.js"></script>
<script>
    $(document).ready(function () {
        var editor = editormd(
            'editormd',
            {
                height:'500px',
                width:'90%',
                path:'http://oclr05hx7.bkt.clouddn.com/markdown/lib/'
            }
        );
        $('#edit').on('click',function(){
            $.post(
                '/postEditArticle',
                {
                    id:$('#hidId').val(),
                    title:$('#title').val(),
                    type:$('#type').val(),
                    description:$('#description').val(),
                    content:editor.getMarkdown()
                },
                function (resp) {
                    if(resp.status!=200){
                        alert(resp.message);
                        return false;
                    }
                    window.location.href='/manage';
                },
                'json');
        });
    });
</script>
</body>
</html>