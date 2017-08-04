@extends('Layouts/adminLayout')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">导航列表</a> &raquo; 添加导航
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加导航</h3>
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
        <form action="{{url('admin/navs')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text" size="50" name="navs_name">
                        </td>
                    </tr>
                    <tr>
                        <th>别名：</th>
                        <td>
                            <input type="text" size="50" name="navs_alias">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>地址：</th>
                        <td>
                            <input type="text" size="50" name="navs_alias">
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" size="50" name="navs_alias">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="button" value="提交" id="submit">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script type="text/javascript">
    	$('#submit').click(function(){
    		var data = $('#formData').serialize();
    		$.ajax({
    		   type: "post",
    		   dataType: "json",
    		   url: '{{url("admin/navs")}}',
    		   data: data,
    		   success: function (data) {
    			   if (data.status==1) {
    				   layer.msg(data.msg,{icon:6});
    				   setTimeout(function(){
    					   window.location.href="{{url('admin/navs')}}";
    				   },2000);
    			   }else{
    				   layer.msg(data.msg,{icon:5});
    			   };
    		   }
       		});
    	})
    </script>
@endsection
