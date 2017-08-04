<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=10,IE=9,IE=8,ie=7">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <title>@yield('title'){{Config::get('web_conf.web_title')}}</title>
	<meta name="keywords" content="{{Config::get('web_conf.web_keywords')}}">
	<meta name="description" content="{{Config::get('web_conf.description')}}">
    <link rel="stylesheet" id="open_social_css-css" href="{{asset('resources/views/home/css/os.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('resources/views/home/css/style.css')}}" media="all">
	<link rel="stylesheet" href="{{asset('resources/views/home/css/swiper.min.css')}}" media="all">
	<link href="{{asset('resources/views/home/css/font-awesome.min.css')}}" rel="stylesheet" media="screen">
	{{--<script type="text/javascript" src="{{asset('resources/views/home/js/base.loading.js')}}"></script>--}}
    {!! Config::get('web_conf.web_count') !!}
    </head>
    <body class="home blog">



    <div class="placeholder"></div>
<script src="{{asset('resources/views/home/js/jquery.js')}}"></script>
<script>window._deel = {
	maillist: '',
	maillistCode: '',
	commenton: 0,
	roll: [0, 0]
  }</script>
<script type="text/javascript">$(function() {
	$(window).scroll(function() {
	  $offset = $('.placeholder').offset(); //不能用自身的div，不然滚动起来会很卡
	  if ($(window).scrollTop() > $offset.top) {
		$('.header').css({
		  'position': 'fixed',
		  'top': '0px',
		  'left': $offset.left + 'px',
		  'z-index': '999'
		});
	  } else {
		$('.header').removeAttr('style');
		$('.container').removeAttr('style');
	  }
	});
  })
</script>
<header class="header" style="height: 52px;">
  <div class="navbar">
	<h1 class="logo">
	  <a href="http://www.huangsite.com/" title="HUANG博客" alt="HUANG博客">HUANG博客</a></h1>
	<ul class="nav">
	  <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item menu-item-home"><a href="http://www.huangsite.com/">首页</a></li>
      @foreach($navs as $nav=>$n)
	     <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
		 <a href="http://www.huangsite.com/category/{{$n->category_id}}">{{$n->category_name}}</a>
         <ul class="sub-menu">
             @foreach($navs2 as $k=>$v)
             @if($n->category_id == $v->category_pid)
             <li class="menu-item menu-item-type-taxonomy menu-item-object-category"><a href="http://www.huangsite.com/category/{{$v->category_id}}">{{$v->category_name}}</a></li>
             @endif
             @endforeach
            </ul>
        </li>
        @endforeach
	</ul>
	<div class="menu pull-right">
	  <form name="formsearch" action="https://www.huangsite.com/search" method="get">
		<input class="search-input" name="keywords" id="search-keyword"
			   type="text" required="required" placeholder=" 搜一下，你就知道！">
		<button type="submit" class="searchbtn" title="搜一下！">
		  <i class="fa"></i>
		</button>
	  </form>
	</div>
</div></header>
@yield('content')
<footer class="footer">
  <div class="footer-inner">
    <div style="padding:0 20px;overflow:hidden;">
      <div class="copyright" style="text-align:center">
        <a href="http://www.huangsite.com/" target="_blank">{{Config::get('web_conf.copyright')}}</a>| {{Config::get('web_conf.beian')}}</div>
    </div>
  </div>
</footer>
<div id="button">
<a href="javascript:;" rel="nofollow" class="totop" title="返回顶部"></a>
</div>
<script type="text/javascript">
    $(document).ready(function() {
    $(function(){
        $(window).scroll(function(){
            if($(this).scrollTop() > 300){
                $('.totop').fadeIn();
            }else{
                $('.totop').fadeOut();
            }
        });
        $('.totop').click(function(){
            $('body,html').animate({scrollTop:0},300);
        })
    })

    });
</script>
</body></html>
