<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta name="keywords" content="枫飞落叶之地,楓飛落葉之地">
    <meta name="description" content="枫飞落叶之地,楓飛落葉之地">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>WoW-heal-calculator-楓飛落葉之地</title>
    <link type="image/x-icon" href="/images/favicon.ico " rel="shortcut icon">
    <link href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/css/global.css" rel="stylesheet"/>
</head>
<body>
<?php include __APP__.'/views/common/header.php';?>

<div class="container">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 content-list sp">
            <div class="form-group">

                <label for="haste" class="col-sm-2 control-label">急速</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="haste" />
                </div>

                <label for="hastePlus" class="col-sm-2 control-label"> - 附加急速</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="hastePlus" value="0" />
                </div>

                <label for="mastery" class="col-sm-2 control-label">精通</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="mastery" />
                </div>

                <label for="masteryPlus" class="col-sm-2 control-label"> - 附加精通</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="masteryPlus" value="0" />
                </div>

                <label for="critical" class="col-sm-2 control-label">暴击</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="critical" />
                </div>

                <label for="criticalPlus" class="col-sm-2 control-label"> - 附加暴击</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="criticalPlus" value="0" />
                </div>

                <p></p>
                <label class="col-sm-2 control-label">治疗量</label>
                <div class="col-sm-10">
                    <input id="heal"  type="text" readonly="readonly" />
                </div>

                <button id="submit" type="button" class="btn btn-primary">计算</button>
                <button id="clear" type="button" class="btn btn-danger">清除</button>
            </div>
        </div>
    </div>
</div>

<?php include __APP__.'/views/common/footer.php';?>
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>

    $('#submit').on('click',function () {
        var haste = parseFloat($('#haste').val());
        var hastePlus = parseFloat($('#hastePlus').val());
        var mastery = parseFloat($('#mastery').val());
        var masteryPlus = parseFloat($('#masteryPlus').val());
        var critical = parseFloat($('#critical').val());
        var criticalPlus = parseFloat($('#criticalPlus').val());

        var heal = (1.08+(critical-criticalPlus)/350)*(1.12+(mastery-masteryPlus)/233)*(1+(haste-hastePlus)/325);
        $('#heal').val(heal);
    });

    $('#clear').on('click',function () {
        $('#haste').val('');
        $('#hastePlus').val(0);
        $('#mastery').val('');
        $('#masteryPlus').val(0);
        $('#critical').val('');
        $('#criticalPlus').val(0);
        $('#heal').val('');
    });
</script>
</body>
</html>