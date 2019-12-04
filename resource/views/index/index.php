<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
  <title>联系人</title>

  <!-- Bootstrap -->
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

  <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
  <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
  <!--[if lt IE 9]>
  <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
  <![endif]-->
  <style>
    .media {
      box-shadow: 10px 15px 15px -12px #000;
      border: solid 1px #ddd;
      /*border-top: 1px solid #ddd;*/
    }
    .media a {
      text-decoration: none;
      color: #212529;
    }
    .media-heading {
      font-size: 14px;
      margin-top: 5px;
    }
    .media-content {
      color: #777777;
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
      <?php
      if (!empty($friends)) {
        $html = '';
        foreach ($friends as $f) {
          $last_msg = isset($msg[$f["id"]])?$msg[$f["id"]]["msg"]:'';
          $link = '/chat/channel/'.$f['id'];
          $html .= '
      <div class="media" onclick="link(\''.$link.'\')">
        <div class="media-left">
            <img class="media-object" alt="64x64"
            src="'.$f['avatar'].'"
                 data-holder-rendered="true" style="width: 64px; height: 64px;">
        </div>
        <div class="media-body">
            <h4 class="media-heading">'.$f['name'].'</h4>
            <p class="media-content">
              '.$last_msg.'
            </p>
        </div>
      </div>';
        }
        echo $html;
      }
      ?>

    </div>

  </div>
</div>

</body>
<script>

  function link(url) {
    location.href=url
  }
</script>
</html>
