@extends('Layouts/indexLayout')
@section('content')
<script type="text/javascript">
    window.onload = function(){
        var rand = Math.round(Math.random()*6+1);
        var url = "{{asset('resources/views/home/js/js')}}"+rand+".html";
        var insertIframe = '<iframe src="'+url+'" width="1200px" height="313px" style="border-width:0px"></iframe>';
        document.getElementById('iframe').innerHTML= insertIframe;
    }
</script>
<style media="screen">
.search-wrap-div {
    width: 100%;
    height: 190px;
    position: absolute;
    top: 0;
}
.form-wrap {
width: 80%;
margin: 0px auto;
height: 35%;
z-index: 100;
position: relative;
}
.form-wrap h3 {
    color: #F4F4F4;
    text-align: center;
    overflow: hidden;
    font-size: 24px;
    margin-top:20px;
    margin-bottom: 10px
}
</style>
<script type="text/javascript" src="{{asset('resources/views/home/js/swiper.min.js')}}"></script>
    <section class="container">
      <div class="banner banner-navbar">
			<div class="swiper-container swiper-container-horizontal" id="iframe">
			</div>
            <div class="search-wrap-div">
                <div class="form-wrap">
                <h3 style="margin-top:100px;margin-bottom: 10px;line-height: 35px">I see no ending, yet high and low I’ll search with my will unbending!</h3>
                <h3 class="fadeInRightBig animated">路漫漫其修远兮? 吾将上下而求索！</h3>
                </div>
            </div>

      </div>
    <script>
		var swiper = new Swiper('.swiper-container', {
			pagination: '.swiper-pagination',
			nextButton: '.swiper-button-next',
			prevButton: '.swiper-button-prev',
			paginationClickable: true,
			spaceBetween: 30,
			centeredSlides: true,
			autoplay: 5000,
			autoplayDisableOnInteraction: false,
			loop: true
		});
    </script>
      <div class="content-wrap">
        <div class="content">
          <div class="sticky">
            <h2 class="title">特别推荐</h2>
            <ul>
                @foreach($recom as $k=>$v)
			    <li class="item"><a href="article/{{$v->article_id}}" target="_blank">
                  <img src="{{$v->article_thumb}}" alt="{{$v->article_title}}">
                  <h3>{{$v->article_title}}</h3>
                  <p class="muted">{{mb_substr(strip_tags($v->article_content),0,100)}}...</p></a>
                </li>
                @endforeach
            </ul>
          </div>
          <h2 class="title">最新发布</h2>
          @foreach($all as $k =>$v)
		<article class="excerpt">
            <div class="focus">
              <a href="article/{{$v->article_id}}" class="thumbnail" target="_blank">
                <img src="{{$v->article_thumb}}" alt="{{$v->article_title}}" title="{{$v->article_title}}"></a>
            </div>
            <header>
              <h2>
                <a href="article/{{$v->article_id}}" title="{{$v->article_title}}" target="_blank">{{$v->article_title}}</a></h2>
            </header>
            <p class="note">​{{mb_substr(strip_tags($v->article_content),0,150)}}...</p>
            <p>
              <span class="muted">
                <i class="icon-user icon12"></i>{{$v->article_author}}</span>
              <span class="muted">
                <i class="ico icon-time icon12"></i>{{date('Y-m-d',$v->article_addtime)}}/发布</span>
              <span class="muted">
                <i class="ico icon-eye-open icon12"></i>{{$v->article_views}}次浏览</span>
            </p>
          </article>
          @endforeach
          <div class="pagenavi clearfix">
            <div class="pages">
              {{$all->links()}}
            </div>
          </div>
        </div>
      </div>

      <aside class="sidebar">
        <div class="widget">
		  <h3 class="widget_tit">热门标签</h3>
          <div class="tag_list">
            <ul>
            @foreach($tag->conf_content as $k=>$v)
			<li><a href="tags/{{$v}}" target="_blank">{{$v}}</a></li>
            @endforeach
			</ul>
          </div>
        </div>
        <div class="widget d_postlist">
          <h3 class="widget_tit">推荐文章</h3>
          <ul>
              @foreach($hot as $k=>$v)
			<li><a href="article/{{$v->article_id}}">
                <span class="thumbnail">
                  <img src="{{$v->article_thumb}}"></span>
                <span class="text">{{$v->article_title}}</span>
                <span class="muted">{{date('Y-m-d',$v->article_addtime)}}</span>
                <span class="muted">
                  <span class="ds-thread-count" data-replace="1">{{$v->article_views}}次阅读</span>
                </span>
              </a>
            </li>
            @endforeach
          </ul>
        </div>
        <div class="widget d_postlist">
          <h3 class="widget_tit">友情链接</h3>
          <ul>
            @foreach($links as $k=>$v)
			<li><a href="{{$v->links_url}}" target="_blank">{{$v->links_name}}</a></li>
            @endforeach
          </ul>
        </div>
        <!-- <div class="widget">
		  <h3 class="widget_tit">最新评�?/h3>
          <div class="com_list">
		               <ul>
			<li><span class="comment_article"><a title="关于程序员那点事" href="http://blog.yzmcms.com/html/yule/35.html">关于程序员那点事</a></span><span class="comment_comment">网友评论�?img src="./YzmCMS官方博客_袁志蒙博客_files/1.gif">怎么没东�?/span></li><li><span class="comment_article"><a title="关于程序员那点事" href="http://blog.yzmcms.com/html/yule/35.html">关于程序员那点事</a></span><span class="comment_comment">网友评论�?img src="./YzmCMS官方博客_袁志蒙博客_files/1.gif"></span></li><li><span class="comment_article"><a title="YzmCMS v3.3正式版发�? href="http://blog.yzmcms.com/html/php/95.html">YzmCMS v3.3正式版发�?/a></span><span class="comment_comment">网友评论�?a href="javascript:void(0);" class="user_name" rel="nofollow">YzmCMS官方博客_袁志蒙博客网�?/a> 回复 <a href="javascript:void(0);" class="user_name" rel="nofollow">管理�?/a> ：谢谢。已处理�?/span></li><li><span class="comment_article"><a title="YzmCMS v3.3正式版发�? href="http://blog.yzmcms.com/html/php/95.html">YzmCMS v3.3正式版发�?/a></span><span class="comment_comment">网友评论�?a href="javascript:void(0);" class="user_name" rel="nofollow"><strong style="color:#DE4C1C">管理�?/strong></a> 回复 <a href="javascript:void(0);" class="user_name" rel="nofollow">YzmCMS官方博客_袁志蒙博客网�?/a> ：登录后�?系统设置-安全设置-是否允许游客评论</span></li><li><span class="comment_article"><a title="YzmCMS v3.3正式版发�? href="http://blog.yzmcms.com/html/php/95.html">YzmCMS v3.3正式版发�?/a></span><span class="comment_comment">网友评论：如何实现游客可以评论？</span></li><li><span class="comment_article"><a title="YzmCMS v3.3正式版发�? href="http://blog.yzmcms.com/html/php/95.html">YzmCMS v3.3正式版发�?/a></span><span class="comment_comment">网友评论�?a href="javascript:void(0);" class="user_name" rel="nofollow"><strong style="color:#DE4C1C">管理�?/strong></a> 回复 <a href="javascript:void(0);" class="user_name" rel="nofollow">YzmCMS官方博客_袁志蒙博客网�?/a> ：模型在后台自己创建就行了，不用下载�?/span></li>			</ul>
          </div>
        </div> -->
        <div class="widget d_textbanner">
            <a class="style03" target="_blank" href="http://www.qcloud.com/redirect.php?redirect=1001&cps_key=62fb69ed8bd49591426a1aa103ea1152">
                <span class="thumbnail">
                  <img src="/uploads/ad1.jpg" alt="腾讯云服务器安全可靠高性能，多种配置供您选择腾讯云服务器安全可靠高性能，多种配置供您选择" title="腾讯云服务器安全可靠高性能，多种配置供您选择"></span>

			</a>
		</div>
        <div class="widget d_textbanner">
			<a class="style03" target="_blank" href="http://www.qcloud.com/redirect.php?redirect=1003&cps_key=62fb69ed8bd49591426a1aa103ea1152">
                <span class="thumbnail">
                  <img src="/uploads/ad2.jpg" alt="腾讯云数据库性能卓越稳定可靠，为您解决数据库运维难题" title="腾讯云数据库性能卓越稳定可靠，为您解决数据库运维难题"></span>

			</a>
		</div>
        <div class="widget d_textbanner">
            <a class="style03" target="_blank" href="http://www.qcloud.com/redirect.php?redirect=1004&cps_key=62fb69ed8bd49591426a1aa103ea1152">
                <span class="thumbnail">
                  <img src="/uploads/ad3.jpg" alt="腾讯云CDN拥有顶尖加速能力，丰富的功能全面覆盖各业务场景的加速需求，最为用户考虑的加速产品" title="腾讯云CDN拥有顶尖加速能力，丰富的功能全面覆盖各业务场景的加速需求，最为用户考虑的加速产品"></span>

			</a>
		</div>
      </aside>
    </section>
@endsection
