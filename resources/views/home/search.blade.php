@extends('Layouts/indexLayout')
@section('content')
<section class="container">
      <div class="content-wrap">
        <div class="content">
          <header class="archive-header">
            <h1>“{{$keyword}}”的结果，共<span>{{count($article)}}</span>条</h1>
          </header>
            @foreach($article as $k => $v)
			<article class="excerpt">
            <div class="focus">
              <a href="article/{{$v->article_id}}" class="thumbnail" target="_blank">
                <img src="/{{$v->article_thumb}}" alt="{{$v->article_title}}" title="{{$v->article_title}}"></a>
            </div>
            <header>
              <h2>
                <a href="article/{{$v->article_id}}" target="_blank">{{$v->article_title}}</a></h2>
            </header>
            <p class="note">{{mb_substr(strip_tags($v->article_content),0,100)}}...</p>
            <p>
              <span class="muted">
                <i class="icon-user icon12"></i>{{$v->article_author}}</span>
              <span class="muted">
                <i class="ico icon-time icon12"></i>{{date('Y-m-d',$v->article_addtime)}}</span>
              <span class="muted">
                <i class="ico icon-eye-open icon12"></i>{{$v->article_views}}次浏览</span>
            </p>
          </article>
          @endforeach

        </div>
      </div>

      <aside class="sidebar">
        <div class="widget d_postlist">
          <h3 class="widget_tit">总点击排行</h3>
          <ul>
            @foreach($recom as $k=>$v)
			<li><a href="article/{{$v->article_id}}">
                <span class="thumbnail">
                  <img src="/{{$v->article_thumb}}" alt="{{$v->article_title}}" title="{{$v->article_title}}"></span>
                <span class="text">{{$v->article_title}}</span>
                <span class="muted">{{date('Y-m-d',$v->article_addtime)}}</span>
                <span class="muted">
                  <span class="ds-thread-count" data-replace="1">{{$v->article_views}}次阅读</span>
                </span>
              </a></li>
              @endforeach
          </ul>
        </div>
		<div class="widget d_textbanner">
            <a class="style03" target="_blank" href="http://www.qcloud.com/redirect.php?redirect=1001&cps_key=62fb69ed8bd49591426a1aa103ea1152">
                <span class="thumbnail">
                  <img src="/uploads/ad1.jpg" alt="腾讯云服务器安全可靠高性能，多种配置供您选择腾讯云服务器安全可靠高性能，多种配置供您选择" title="腾讯云服务器安全可靠高性能，多种配置供您选择"></span>

			</a>
		</div>
      </aside>﻿
	  </section>
@endsection
