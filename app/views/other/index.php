<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta name="keywords" content="枫飞落叶之地,楓飛落葉之地">
    <meta name="description" content="枫飞落叶之地,楓飛落葉之地">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Other-楓飛落葉之地</title>
    <link type="image/x-icon" href="/images/favicon.ico " rel="shortcut icon">
    <link href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/css/global.css" rel="stylesheet"/>
</head>
<body>
<?php include __APP__.'/views/common/header.php';?>

<div class="container">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 content-list sp">
            <p>正在学习WebSocket推送，这里先放个自己写的小聊天室demo试试。</p>
            <div class="chat-box">
                <div class="chat-display">
                    <div id="output" class="chat-content">

                    </div>
                    <div class="chat-user">
                        <h4>在线的用户(<span id="userCount" style="font-size:18px;">0</span>/20)</h4>
                        <hr>
                        <ul id="userList"></ul>
                    </div>
                </div>
                <div class="form-group chat-input">
                    <label for="name">输入一些文字：</label>
                    <textarea id="input" class="form-control" rows="3"></textarea>
                    <button id="send" type="button" class="btn btn-primary">发送</button>
                    <button id="clear" type="button" class="btn btn-danger">清除</button>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include __APP__.'/views/common/footer.php';?>
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
    var wsUri ="ws://127.0.0.1:8888";
    var output;
    var userList;
    var nickname;
    var userCount;

    function init() {
        output = document.getElementById("output");
        userList = document.getElementById('userList');
        userCount = document.getElementById('userCount');
        testWebSocket();
    }

    function testWebSocket() {
        websocket = new WebSocket(wsUri);
        websocket.onopen = function(evt) {
            onOpen(evt)
        };
        websocket.onclose = function(evt) {
            onClose(evt)
        };
        websocket.onmessage = function(evt) {
            onMessage(evt)
        };
        websocket.onerror = function(evt) {
            onError(evt)
        };
    }

    function onOpen(evt) {
        writeToScreen("聊天室连接成功...");
        var nickname = '';
        while(nickname==''){
            nickname = prompt("请输入昵称", "匿名");
        }
        if(!nickname){
            websocket.close();
            return;
        }
        doRename(nickname);
    }

    function onClose(evt) {
        writeToScreen("断开与聊天室的连接...");
    }

    function onMessage(evt) {
        var msg = JSON.parse(evt.data);
        if(msg.type=='rename'){
            nickname = msg.data.nickname;
            writeToScreen('现在你的昵称是：<span style="color: blue;">'+msg.data.nickname+'</span>');
            addToUserList(msg.data.id,msg.data.nickname+'（我）');
            for(var index=0; index<msg.data.onlineUsers.length; index++){
                addToUserList(msg.data.onlineUsers[index].id,msg.data.onlineUsers[index].nickname);
            }
            setCurrentUserCount();
        }else if(msg.type=='chat'){
            writeToScreen('<span style="color: blue;">'+ msg.data+'</span>');
        }else if(msg.type == 'connect'){
            writeToScreen(msg.data.nickname+" 加入了聊天");
            addToUserList(msg.data.id,msg.data.nickname);
            setCurrentUserCount();
        }else if(msg.type == 'disconnect'){
            writeToScreen(msg.data.nickname+" 退出了聊天");
            deleteFromUserList(msg.data.id,msg.data.nickname);
            setCurrentUserCount();
        }
    }

    function onError(evt) {
        writeToScreen('<span style="color: red;">ERROR:</span> '+ evt.data);
    }

    function doSend(message) {
        writeToScreen("<span style='color: green;'>"+nickname+"(我): "+ message+"</span>");
        message = JSON.stringify({
            'type':'chat',
            'value':message
        });
        websocket.send(message);
    }

    function doRename(nickname) {
        websocket.send(JSON.stringify({
            'type':'rename',
            'value':nickname
        }));
    }

    function writeToScreen(message) {
        var pre = document.createElement("p");
        pre.style.wordWrap = "break-word";
        pre.innerHTML = message;
        output.appendChild(pre);
    }

    function addToUserList(id,nickname) {
        var user = parseDom('<li data-id="'+id+'"><a><span class="glyphicon glyphicon-user"></span></a>&nbsp;&nbsp;<span>'
            +nickname+'</span></li>');
        userList.appendChild(user[0]);
    }
    
    function deleteFromUserList(id) {

        for (var i =0; i < userList.childNodes.length; i++){
            if(userList.childNodes[i].getAttribute('data-id')==id){
                userList.removeChild(userList.childNodes[i]);
                break;
            }
        }
    }
    
    function setCurrentUserCount() {
        userCount.innerHTML = userList.childNodes.length;
    }

    function parseDom(arg) {

        var objE = document.createElement("div");

        objE.innerHTML = arg;

        return objE.childNodes;

    }
    window.addEventListener("load", init, false);
    document.getElementById('send').onclick= function(){
        var sendData = document.getElementById('input').value;
        document.getElementById('input').value = '';
        if(sendData==''){
            alert('请输入');
            return;
        }
        if(sendData=='-1'){
            websocket.close();
            return;
        }
        doSend(sendData);
    };
    document.getElementById('clear').onclick= function(){
        document.getElementById('input').value = '';
    }
</script>
</body>
</html>