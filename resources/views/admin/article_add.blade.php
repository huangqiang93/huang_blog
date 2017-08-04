@extends('Layouts/adminLayout')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">文章列表</a> &raquo; 添加文章
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加文章</h3>
            @if (count($errors)>0)
                <div class="mark">
                    @foreach ($errors->all() as $error)
                        <p>{{$error}}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/article')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>文章分类：</th>
                        <td>
                            <select name="article_categoryid">
                                <option value="">==请选择==</option>
                                @foreach($data as $category)
    							<option value="{{$category->category_id}}" >{{$category->category_name}}</option>
    							@endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th width="120"><i class="require">*</i>文章标签：</th>
                        <td>
                            <select name="article_tags">
                                <option value="">==请选择==</option>
                                @foreach($tags->conf_content as $k=>$v)
                                <option value="{{$v}}" >{{$v}}</option>
    							@endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="article_title">
                        </td>
                    </tr>
                    <tr>
                        <th>文章作者：</th>
                        <td>
                            <input type="text" name="article_author" value="大表哥">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章缩略图：</th>
                        <td>
                            <input type="text" size="50" name="article_thumb">
                            <input id="file_upload" type="file" name="file_upload" multiple="ture">
                        </td>
                        <script src="{{asset('resources/views/admin/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                        <link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/uploadify/uploadify.css')}}">
                        <style>
                            .uploadify{display:inline-block;}
                            .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
                            table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
                        </style>
                        <script type="text/javascript">
                    		<?php $timestamp = time();?>
                    		$(function() {
                    			$('#file_upload').uploadify({
                                    'buttonText'    :'选择图片',
                    				'formData'     : {
                    					'timestamp' : '<?php echo $timestamp;?>',
                    					'_token'     : "{{csrf_token()}}"
                    				},
                    				'swf'      : "{{asset('resources/views/admin/uploadify/uploadify.swf')}}",
                    				'uploader' : "{{url('admin/upload')}}",
                                    'onUploadSuccess' : function(file, data, response) {
                                        $('input[name=article_thumb]').val(data);
                                        $('#img_thumb').attr('src','/'+data);
                                    }
                    			});
                    		});
                    	</script>
                    </tr>
                    <tr>
                        <th>图片预览：</th>
                        <td>
                            <img id="img_thumb" src="" alt="" style="max-width:350px;max-height:200px">
                        </td>
                    </tr>
                    <tr>
                        <th>文章内容：</th>
                        <td>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources/views/admin/ueditor/ueditor.config.js')}}"></script>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources/views/admin/ueditor/ueditor.all.min.js')}}"> </script>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources/views/admin/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                            <script id="editor" type="text/plain" name="article_content"  style="width:970px;height:500px;"></script>
                            <script type="text/javascript">var ue = UE.getEditor('editor');</script>
                            <style>
                                .edui-default{line-height: 28px;}
                                div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                                {overflow: hidden; height:20px;}
                                div.edui-box{overflow: hidden; height:22px;}
                            </style>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection
