<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>客户端对象</title>
  <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
  <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
  <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
  <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"
          integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
          crossorigin="anonymous"></script>

  <style>
    .msg-list {
      width: 100%;
    }
    .messenger-container {
      padding: 8px 15px 8px 13px;
      margin: 0 0 25px 25px;
      float: left;
      max-width: 70%;
      background: aquamarine;
      border-radius: 10px;
      min-width: 20%;
      position: relative; box-sizing: border-box;
      box-shadow: 7px 10px 6px -5px #BBC0C7;
    }
    .messenger-container p {
      color: #3D3D3D;
      font-size: 12px;
      margin-bottom: 6px;
      line-height: 18px;
      word-wrap: break-word; margin: 0;
    }
    .sender .messenger-container {
      float: right;
      margin-right: 25px;
      width: auto;
      background: gold;
      margin-left: 0px;
      padding: 8px 15px 8px 13px;
    }
    .clear {
      clear:both;
      width: 100%;
      padding: 0px !important;
      margin: 0px;
      height:5px;
    }
    .messenger-container::before {
      width: 0px;
      height: 0px;
      border-top: 8px solid transparent;
      border-bottom: 8px solid transparent;

      border-right:15px solid aquamarine;
      content: "";
      position: absolute;
      top: 9px;
      left: -15px;
    }
    .sender .messenger-container::before {
      width: 0px;
      height: 0px;
      border-top: 8px solid transparent;
      border-bottom: 8px solid transparent;
      border-left: 15px solid gold;
      content: "";
      position: absolute;
      top: 9px;
      left: 99%;border-right: none;
    }
    .msg-icon {
      float: left;
    }
    .msg-icon-right {
      float: right;
    }

    .chat-content {
      height: 450px;
      overflow: scroll;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="row">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                  data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">
            <img alt="Brand" src="/image/kotori_icon.png" width="25px">
          </a>
          <p class="navbar-text">当前用户数：<b id="PeopleNum" style="color: darkcyan">0</b></p>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="#">欢迎： <span class="sr-only">(current)</span><?= $user['name']; ?></a></li>
            <li><a href="/logout">退出</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <div class="col-sm-12">
      <div id="status_msg">
      </div>
    </div>
  </div>
  <div class="row chat-content" id="chat-container">
    <div class="col-sm-12 col-md-12">
      <div class="panel panel-default">
        <div class="panel-body" id="msg">

        </div>
      </div>
    </div>
  </div>


  <div class="row bottom-input">
    <div class="col-sm-12 col-md-12">
      <div class="form-group">
        <textarea class="form-control" rows="1" id="text"></textarea>
      </div>
      <button type="submit" class="btn btn-success btn-block" onclick="song()">发送</button>
    </div>

  </div>

</div>

</body>
<script>
  //注册键盘事件
  document.onkeydown = function (e) {
    //捕捉回车事件
    var ev = (typeof event != 'undefined') ? window.event : e;
    if (ev.keyCode == 13) {
      song();
    }
  };
  var msg = document.getElementById("msg");
  var PeopleNum = document.getElementById("PeopleNum");
  var wsServer = 'ws://192.168.10.10:18308/chat';
  //调用websocket对象建立连接：
  //参数：ws/wss(加密)：//ip:port （字符串）
  var websocket = new WebSocket(wsServer);
  //onopen监听连接打开
  websocket.onopen = function (evt) {
    // console.log(evt)
    //websocket.readyState 属性：
    /*
    CONNECTING  0   The connection is not yet open.
    OPEN    1   The connection is open and ready to communicate.
    CLOSING 2   The connection is in the process of closing.
    CLOSED  3   The connection is closed or couldn't be opened.
    */
    // if (websocket.readyState == 1) {
    //   msg.innerHTML = "链接已建立！<br/>"
    // } else {
    //   msg.innerHTML = "Something is Wrong !<br/>";
    // }
    let data = {
      'cmd': 'home.bind',
      'data': {
        "token": '<?=$token;?>'
      },
      "ext": {
        "ip": '127.0.0.1'
      }
    }
    // 将uid推送到服务端，与fd进行绑定
    websocket.send(JSON.stringify(data));
  };



  //监听连接关闭
  websocket.onclose = function (evt) {
    console.log(evt)
    console.log(evt.data)
    if (evt.data) {
      var jsonData = JSON.parse(evt.data);
      if (jsonData.type === 'system') {
        addSystemMsg(jsonData.code,jsonData.msg)
      }
    } else {
      addSystemMsg(500,'链接已中断！')
    }
  };
  //onmessage 监听服务器数据推送
  websocket.onmessage = function (evt) {
    if (evt.data) {
      // console.log(evt.data,123)
      var jsonData = JSON.parse(evt.data);
      // console.log(jsonData,1);
      if (jsonData.type === 'chat') {
        var name = jsonData.me === true ? '我：' : '用户' + jsonData.user_id + "："
        msg.innerHTML += addMsg(name, jsonData.msg, jsonData.time, jsonData.avatar, jsonData.me) + "<br/>"
        jump()
      } else if (jsonData.type === 'number') {
        PeopleNum.innerHTML = jsonData.msg;
      } else {
        addSystemMsg(jsonData.code,jsonData.msg)
      }
    }
  };
  //监听连接错误信息
  websocket.onerror = function (evt, e) {
    websocket.close()
  };
</script>
<script>
  function song() {
    var text = document.getElementById('text').value;
    text_without_br=text.replace(/\n/g,"")
    // console.log(text_without_br,text_without_br !== '',text_without_br !== null,1)
    if (text_without_br && text_without_br !== '' && text_without_br !== null ) {
      document.getElementById('text').value = '';
      text=text.replace(/\n/g,"<br/>")

      //向服务器发送数据
      var msg = {
        "cmd": "home.echo",
        "data": {
          "token": "<?= $token;?>",
          "msg": text,
          'channel_id': "<?= $channel_id;?>"
        },
        "ext": {
          "ip": '127.0.0.1'
        }
      }
      // console.log(JSON.stringify(msg))
      websocket.send(JSON.stringify(msg));
    }
  }


  function isJsonString(str) {
    try {
      if (typeof JSON.parse(str) == "object") {
        return true;
      }
    } catch (e) {
    }
    return false;
  }

  function addMsg(name, content, time, avatar, me) {
    if (me) {
      var html = '<div class="msg-list sender">\n' +
        '          <div class="msg-icon-right">\n' +
        '            <img src="<?= $user['avatar'];?>" width="48px">\n' +
        '          </div>\n' +
        '          <div class="messenger-container">\n' +
        '            <p>'+ content +'</p>\n' +
        '          </div>\n' +
        '        </div>\n' +
        '        <div class="clear"></div>'
    } else {
      var html = '<div class="msg-list">\n' +
        '          <div class="msg-icon">\n' +
        '            <img src="'+avatar+'" width="48px">\n' +
        '          </div>\n' +
        '          <div class="messenger-container">\n' +
        '            <p>' + content + '</p>\n' +
        '          </div>\n' +
        '        </div>\n' +
        '        <div class="clear"></div>'
    }
    return html;
  }

  function addSystemMsg(code, msg) {
    switch (code) {
      case 200:
        status = 'success';
        time = 1500;
        break;
      case 500:
        status = 'danger';
        time = 3000;
        break;
      default:
        status = 'danger';
        time = 3000;
    }
    var html = '<div class="alert alert-'+status+'" role="alert">'+msg+'</div>\n'
    $('#status_msg').append(html)
    $('.alert').hide(time)
  }


  function jump() {
    var liBox = $('.msg-list').last();
    var position = liBox.position()
    $("#chat-container").scrollTop(position.top)
  }

  // window.onbeforeunload = function (event) {
  //   websocket.close()
  //   event.returnValue = "...";
  // };
</script>
</html>
