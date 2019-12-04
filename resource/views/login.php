<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewPort" content="width=device-width,initial-scale=1">
	<title>登录</title>
    <style>
        body{
            background: #00c0ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Helvetica Neue", Helvetica, Arial, "PingFang SC", "Hiragino Sans GB", "Heiti SC", "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif;
        }
        .login-block{
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 5rem;
            width: 20em;
            height: 25em;
            background: #3dceba;
            border-radius: 10px;
            box-shadow: 0 0 16px #333;
        }
        .login-animate,.password-animate{
            width: 10em;
            height: 10em;
            border-radius: 5em;
            background: #cefefb;
            margin: 20px 0;
            position: relative;
            overflow: hidden;
        }
        .login-animate div,.password-animate div{
            transition: all 0.5s;
            -o-transition: all 0.5s;
            -moz-transition: all 0.5s;
            -webkit-transition: all 0.5s;
        }
        .login-animate .body{
            background-image: url(/img/body.png);
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
            width: 6.5em;
            height: 6em;
            position: absolute;
            bottom: -2em;
            left: calc(50% - 3.25em);
            z-index: 0;
        }
        .login-animate .head{
            position: relative;
            background-image: url(/img/face.png);
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
            width: 7.5em;
            height: 7.25em;
            position: absolute;
            bottom: 1em;
            left: calc(50% - 3.75em);
            z-index: 1;
        }
        .login-animate .left-ear{
            background-image: url(/img/left-ear.png);
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
            width: 2em;
            height: 2em;
            position: absolute;
            bottom: 5.5em;
            left: calc(50% - 4em);
        }
        .login-animate .right-ear{
            background-image: url(/img/right-ear.png);
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
            width: 2em;
            height: 2em;
            position: absolute;
            bottom: 5.5em;
            left: calc(50% + 2em);
        }
        .login-animate .left-eye{
            background-image: url(/img/eye.png);
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
            width: 1em;
            height: 1em;
            position: absolute;
            bottom: 4em;
            left: calc(50% - 2.5em);
        }
        .login-animate .right-eye{
            background-image: url(/img/eye.png);
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
            width: 1em;
            height: 1em;
            position: absolute;
            bottom: 4em;
            left: calc(50% + 1.5em);
        }
        .login-animate .face{
            background-image: url(/img/muzzle.png);
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
            width: 4em;
            height: 4em;
            position: absolute;
            bottom: 0em;
            left: calc(50% - 2em);
        }
        .login-animate .nose{
            background-image: url(/img/nose.png);
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
            width: 1em;
            height: 1em;
            position: absolute;
            top: 0.5em;
            left: calc(50% - 0.5em);
        }
        .login-animate .mouth{
            background-image: url(/img/mouth-smile.png);
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
            width: 2em;
            height: 1em;
            position: absolute;
            bottom: 1em;
            left: calc(50% - 1em);
        }
        .login-animate .left-arm{
            background-image: url(/img/left-arm.png);
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
            width: 3em;
            height: 7em;
            position: absolute;
            bottom: -7.5em;
            left: 1em;
            z-index: 2;
            transition: bottom 0.5s;
        }
        .login-animate .right-arm{
            background-image: url(/img/right-arm.png);
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
            width: 3em;
            height: 7em;
            position: absolute;
            bottom: -7.5em;
            left: 6em;
            z-index: 2;
            transition: bottom 0.5s;
        }
        .password-animate .mouth.show{
            width: 1em;
            left: calc(50% - 0.5em);
            background-image: url(/img/mouth-circle.png);
        }
        .password-animate .left-arm.show,.password-animate .right-arm.show{
            bottom: -1.7em!important;
        }
        .password-animate .left-arm,.password-animate .right-arm{
            bottom: -0.5em;
        }
        .username-animate .left-ear {
            left: 1.5em;
        }
        .username-animate .right-ear {
            left: 7.5em;
        }
        .username-animate .left-eye {
            left: 0.5em;
            bottom: 3.5em;
        }
        .username-animate .left-eye.doe,.username-animate .right-eye.doe{
            background-image: url(/img/eye-doe.png);
        }

        .username-animate .right-eye {
            left: 4em;
            bottom: 3.5em;
        }
        .username-animate .face {
            left: 1em;
        }
        .username-animate .nose {
            left: 0.9em;
            top: 0.65em;
        }
        .username-animate .mouth {
            bottom: 0.75em;
            background-image: url(/img/mouth-half.png);
        }
        .username-animate .mouth.doe{
            background-image: url(/img/mouth-open.png);
            height: 2em;
            bottom: 0.5em;
        }
        .login-form{
            width: calc(100% - 5em);
            padding: 0 2.5em;
        }
        .username,.password{
            position: relative;
            width: 100%;
            margin: 20px 0;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 5px 0 #333;
        }
        .username>input,.password>input{
            width: calc(100% - 20px);
            padding: 0 10px;
            height: 2.5em;
            border: 0;
            border-radius: 5px;
        }
        .password>input{
            width: calc(100% - 3.3em);
            padding: 0 2.3em 0 1em;
        }
        .pwd-eye{
            width: 1.2em;
            height: 1.2em;
            position: absolute;
            top: calc(50% - 0.6em);
            right: 0.5em;
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
        }
        .btn-gradient.block {
            display: block;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
        /* Gradient buttons */
        .btn-gradient {
            margin: 5px;
            text-decoration: none;
            color: white;
            padding: 10px 30px;
            display: inline-block;
            position: relative;
            border: 1px solid rgba(0,0,0,0.21);
            border-bottom: 4px solid rgba(0,0,0,0.21);
            border-radius: 4px;
            text-shadow: 0 1px 0 rgba(0,0,0,0.15);
        }
        .btn-gradient.green {
            background: rgba(130,200,160,1);
            background: -moz-linear-gradient(top, rgba(130,200,160,1) 0%, rgba(130,199,158,1) 100%);
            background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(130,200,160,1)), color-stop(100%, rgba(130,199,158,1)));
            background: -webkit-linear-gradient(top, rgba(130,200,160,1) 0%, rgba(130,199,158,1) 100%);
            background: -o-linear-gradient(top, rgba(130,200,160,1) 0%, rgba(130,199,158,1) 100%);
            background: -ms-linear-gradient(top, rgba(130,200,160,1) 0%, rgba(130,199,158,1) 100%);
            background: linear-gradient(to bottom, rgba(130,200,160,1) 0%, rgba(124, 185, 149, 1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#82c8a0', endColorstr='#82c79e', GradientType=0 );
        }

        .btn-gradient.green:hover {
            background: rgba(250,90,90,1);
            background: -webkit-gradient(linear, 0 0, 0 100%, from(rgba(250,90,90,1)), to(rgba(232,81,81,1)));
            background: -webkit-linear-gradient(rgba(250,90,90,1) 0%, rgba(232,81,81,1) 100%);
            background: -moz-linear-gradient(rgba(250,90,90,1) 0%, rgba(232,81,81,1) 100%);
            background: -o-linear-gradient(rgba(250,90,90,1) 0%, rgba(232,81,81,1) 100%);
            background: linear-gradient(rgba(250,90,90,1) 0%, rgba(232,81,81,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fa5a5a', endColorstr='#e85151', GradientType=0 );
        }

        .btn-gradient.green:active  {background: #E35252;}
    </style>
</head>
<body>
	<div class="login-block">
		<div class="login-animate">
			<div class="left-ear"></div>
			<div class="right-ear"></div>
			<div class="head">
				<div class="left-eye"></div>
				<div class="right-eye"></div>
				<div class="face">
					<div class="nose"></div>
					<div class="mouth"></div>
				</div>
			</div>
			<div class="body"></div>
			<div class="left-arm"></div>
			<div class="right-arm"></div>
		</div>
		<div class="login-form">
            <form method="post" action="/login" name='form1'>
                <div class="username">
                    <input type="text" name="username">
                </div>
                <div class="password">
                    <input type="password" name="password">
                    <div class="pwd-eye" style="background-image: url('img/password-show.png');" data-flag="hide"></div>
                </div>
                <a href="javascript:document.form1.submit();" class="btn-gradient green block">登陆</a>
            </form>
		</div>
	</div>
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".pwd-eye").hide();
			$(".pwd-eye").click(function(){
				var flag = $(this).attr('data-flag');
				$(this).css('background-image','url("img/password-'+flag+'.png")');
				$(this).attr('data-flag',flag=='show'?'hide':'show');
				$('input[name="password"]').attr('type',flag=='show'?'password':'text');
				if(flag!='show'&&$('input[name="password"]').val() != ''){
					$('.left-arm').addClass('show');
					$('.mouth').addClass('show');
					$('.right-arm').addClass('show');
				}else{
					$('.left-arm').removeClass('show');
					$('.mouth').removeClass('show');
					$('.right-arm').removeClass('show');
				}
			});
			$('input[name="username"]').focus(function(){
				$(".login-animate").addClass('username-animate');
				$(".login-animate").removeClass('password-animate');
				var length = $(this).val().length;
				getposition(length);
			});
			$('input[name="username"]').bind('input', function(){
				var length = $(this).val().length;
				getposition(length);
			});
			function getposition(length){
				var face = parseFloat(1.5/36*length);
				var nose = parseFloat(1/36*length);
				var left_eye = parseFloat(1.5/36*length);
				var right_eye = parseFloat(2/36*length);
				var left_ear = parseFloat(1/36*length);
				var right_ear = parseFloat(1/36*length);
				$('.face').css('left',1+(face>1.5?1.5:face)+'em');
				$('.nose').css('left',0.9+(nose>1?1:nose)+'em');
				$('.left-eye').css('left',0.5+(left_eye>1.5?1.5:left_eye)+'em');
				$('.right-eye').css('left',4+(right_eye>2?2:right_eye)+'em');
				$('.left-ear').css('left',1.5-(left_ear>1?1:left_ear)+'em');
				$('.right-ear').css('left',7.5-(right_ear>1?1:right_ear)+'em');
				if(length >= 6){
					$('.left-eye').addClass('doe');
					$('.right-eye').addClass('doe');
					$('.mouth').addClass('doe');
				}else{
					$('.left-eye').removeClass('doe');
					$('.right-eye').removeClass('doe');
					$('.mouth').removeClass('doe');
				}
			}
			$('input[name="username"]').blur(function(){
				$(".login-animate").removeClass('username-animate');
				$(".login-animate").removeClass('password-animate');
				$('.face').attr('style','');
				$('.nose').attr('style','');
				$('.left-eye').attr('style','');
				$('.right-eye').attr('style','');
				$('.left-ear').attr('style','');
				$('.right-ear').attr('style','');
			});
		  	$('input[name="password"]').focus(function(){
				$(".pwd-eye").show();
				$(".login-animate").removeClass('username-animate');
				$(".login-animate").addClass('password-animate');
			});
			$('input[name="password"]').blur(function(){
				if($(this).val() == '') {
					$(".pwd-eye").hide();
					$(".login-animate").removeClass('username-animate');
					$(".login-animate").removeClass('password-animate');
				}
			});

		});
	</script>
</body>
</html>
