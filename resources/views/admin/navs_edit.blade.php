@extends('Layouts/adminLayout')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
	<!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
	<i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="{{url('admin/navs')}}">全部导航</a> &raquo; 新增导航
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
	<div class="result_title">
		<h3>编辑导航</h3>
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
	<form action="{{url('admin/navs/'.$field->navs_id)}}" method="post">
        <input type="hidden" name="_method" value="put">
		{{csrf_field()}}
		<table class="add_tab">
            <tbody>
                <tr>
                    <th><i class="require">*</i>名称：</th>
                    <td>
                        <input type="text" size="50" name="navs_name" value="{{$field->navs_name}}">
                    </td>
                </tr>
                <tr>
                    <th>别名：</th>
                    <td>
                        <input type="text" size="50" name="navs_alias" value="{{$field->navs_alias}}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>地址：</th>
                    <td>
                        <input type="text" size="50" name="navs_alias" value="{{$field->navs_url}}">
                    </td>
                </tr>
                <tr>
                    <th>排序：</th>
                    <td>
                        <input type="text" size="50" name="navs_alias" value="{{$field->navs_order}}">
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
@endsection
