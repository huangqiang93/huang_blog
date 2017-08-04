@extends('Layouts/indexLayout')
@section('title')
{{$article->article_title}}_
@endsection
@section('content')
<section class="container">
      <div class="content-wrap">
        <div class="content">
          <header class="article-header">
            <h1 class="article-title"></h1><h1>{{$article->article_title}}</h1>
            <div class="meta">
              <span class="muted">
                <i class="icon-user icon12"></i>{{$article->article_author}}</span>
              <time class="muted">
                <i class="ico icon-time icon12"></i>{{date('Y-m-d H:i:s',$article->article_addtime)}}</time>
              <span class="muted">
                <i class="ico icon-eye-open icon12"></i>{{$article->article_views}}次浏览</span>
            </div>
          </header>
          <article class="article-content">
            <blockquote>
              <p> <strong>摘要：</strong>{{mb_substr(strip_tags($article->article_content),0,100)}}...</p>
			</blockquote>
              {!! $article->article_content !!}
              <div class="related-post">
              <h6>随机文章</h6>
              <dl class="fix">
                <div id="tag741ea220ff5887504d724069fe0ee1bf">
                    @foreach($random as $k=>$v)
					<dd><a href="http://www.huangsite.com/article/{{$v->article_id}}" title="{{$v->article_title}}">
                      <img src="/{{$v->article_thumb}}" alt="{{$v->article_title}}">
                      <span>{{$v->article_title}}</span></a>
                    </dd>
                    @endforeach
                </div>
              </dl>
            </div>
            <!--related:end-->
			</article>
          <nav class="article-nav">
            @if($prev_next['prev'])<span class="article-nav-prev">上一篇：<a href="http://www.huangsite.com/article/{{$prev_next['prev']->article_id}}">{{$prev_next['prev']->article_title}}</a></span>@else <span class="article-nav-prev">上一篇：没有上一篇了</span>@endif
            @if($prev_next['next'])<span class="article-nav-next">下一篇：<a href="http://www.huangsite.com/article/{{$prev_next['next']->article_id}}">{{$prev_next['next']->article_title}}</a></span>@else <span class="article-nav-next">下一篇：已经是最后一篇了</span>@endif
		  </nav>
      </div>
      </div>
      <aside class="sidebar">
        <div class="widget d_postlist">
          <h3 class="widget_tit">推荐文章</h3>
          <ul>
              @foreach($hot as $k=>$v)
			<li><a href="http://www.huangsite.com/article/{{$v->article_id}}">
                <span class="thumbnail">
                  <img src="/{{$v->article_thumb}}" alt="{{$v->article_title}}" title="{{$v->article_title}}"></span>
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
