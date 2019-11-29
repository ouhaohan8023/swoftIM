<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
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
    .right {
      float: right;
    }
    .media-footer {
      color: #9E9E9E;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="row">
    <div class="well well-sm">当前用户数：
      <b id="PeopleNum" style="color: darkcyan">0</b>
    </div>
    <div id="status_msg">
    </div>
  </div>
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-body" id="msg">

      </div>
    </div>
  </div>


  <div class="row">
    <div class="form-group">
      <textarea class="form-control" rows="3" id="text"></textarea>
    </div>
    <button type="submit" class="btn btn-success right" onclick="song()">发送</button>
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

  function song() {
    var text = document.getElementById('text').value;
    document.getElementById('text').value = '';
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
    console.log(JSON.stringify(msg))
    websocket.send(JSON.stringify(msg));
  }

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
      console.log(evt.data,123)
      var jsonData = JSON.parse(evt.data);
      console.log(jsonData,1);
      if (jsonData.type !== 'system') {
        var name = jsonData.me === true ? '我：' : '用户' + jsonData.user_id + "："
        msg.innerHTML += addMsg(name, jsonData.msg, jsonData.time, jsonData.me) + "<br/>"
      } else {
        addSystemMsg(jsonData.code,jsonData.msg)
        // if (evt.data) {
        //   msg.innerHTML += evt.data + '<br>';
        // } else {
        //   PeopleNum.innerHTML = evt.ppp;
        // }
      }
    }
  };
  //监听连接错误信息
  websocket.onerror = function (evt, e) {
    websocket.close()
  };
</script>
<script>
  function isJsonString(str) {
    try {
      if (typeof JSON.parse(str) == "object") {
        return true;
      }
    } catch (e) {
    }
    return false;
  }

  function addMsg(name, content, time, me) {
    if (me) {
      var html = '<div class="media">\n' +
        '          <div class="media-body text-right">\n' +
        '            <h5 class="media-heading">'+name+'</h5>\n' +
        '            '+content+'\n' + '<div class="media-footer">'+time+'\n'+'</div>'
        '          </div>\n' +
        '          <div class="media-right">\n' +
        '            <a href="#">\n' +
        '              <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNmViNjRhN2ZiMSB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE2ZWI2NGE3ZmIxIj48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxMy4wNzgxMjUiIHk9IjM2LjM2ODc1Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" data-holder-rendered="true" style="width: 64px; height: 64px;">\n' +
        '            </a>\n' +
        '          </div>\n' +
        '        </div>'
    } else {
      var html = '<div class="media">\n' +
        '          <div class="media-left">\n' +
        '            <a href="#">\n' +
        '              <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNmViNjRhN2ZiMSB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE2ZWI2NGE3ZmIxIj48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxMy4wNzgxMjUiIHk9IjM2LjM2ODc1Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" data-holder-rendered="true" style="width: 64px; height: 64px;">\n' +
        '            </a>\n' +
        '          </div>\n' +
        '          <div class="media-body">\n' +
        '            <h5 class="media-heading">' + name + '</h5>\n' +
        '            ' + content + '\n' +
        '            <div class="media-footer">\n' +
        '                '+time+'\n' +
        '            </div>'
        '          </div>\n' +
        '        </div>'
    }
    return html;
  }

  function addSystemMsg(code, msg) {
    switch (code) {
      case 200:
        $status = 'success';
        break;
      case 500:
        $status = 'danger';
        break;
      default:
        $status = 'danger';
    }
    var html = '<div class="alert alert-'+$status+'" role="alert">'+msg+'</div>\n'
    $('#status_msg').append(html)
  }

  // window.onbeforeunload = function (event) {
  //   websocket.close()
  //   event.returnValue = "...";
  // };
</script>
</html>
