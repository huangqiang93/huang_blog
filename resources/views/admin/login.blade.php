<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<script type="text/javascript" src="lib/PIE_IE678.js"></script>
<![endif]-->
<link href="{{asset('resources/views/admin/css/H-ui.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('resources/views/admin/css/H-ui.login.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('resources/views/admin/css/style.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('resources/views/admin/css/iconfont.css')}}" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<script src="{{asset('resources/views/admin/js/jquery.js')}}"></script>
<title>后台登录 - H-ui.admin v2.3</title>
<meta name="keywords" content="HUANG-BLOG">
<meta name="description" content="HUANG-BLOG">
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value="" />
<!-- <div class="header"></div> -->
<div class="loginWraper">
    <iframe src="{{asset('resources/views/admin/css/js2.html')}}" width="100%" height="567px" style="border-width:0px"></iframe>
  <div id="loginform" class="loginBox">
    <form class="form form-horizontal" action="" method="post">
        @if(session('message'))
        <div class="row cl">
          <div class="formControls col-xs-8 col-xs-offset-3">
            <label for="online" style="color:red">{{session('message')}}</label>
          </div>
        </div>
        @endif
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
        <div class="formControls col-xs-8">
        {{csrf_field()}}
          <input id="" name="username" type="text" placeholder="用户名" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
        <div class="formControls col-xs-8">
          <input id="" name="password" type="password" placeholder="密码" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input class="input-text size-L" type="text" name="captcha" placeholder="验证码" value="" style="width:150px;">
          <img src="{{url('admin/captcha')}}" id="captcha"> <a id="kanbuq" style="color:white">看不清，换一张</a> </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <label for="online" style="color:white">
            <input type="checkbox" name="online" id="online" value="">
            使我保持登录状态</label>
        </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
          <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
        </div>
      </div>
    </form>
  </div>
</div>
<div class="footer">Copyright huang.com Powered by H-ui.admin</div>
<script type="text/javascript">
    $(function(){
        // var url = {{url('admin/captcha')}}
        $('#kanbuq').click(function(){
            $('#captcha').attr("src","http://huang.com/admin/captcha?"+Math.random());
        });
    })
</script>
</body>
</html>
