@extends('Layouts/adminLayout')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
	<!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
	<i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="{{url('admin/links')}}">全部友链</a> &raquo; 编辑友链
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
	<div class="result_title">
		<h3>编辑友链</h3>
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
	<form action="{{url('admin/links/'.$field->links_id)}}" method="post">
        <input type="hidden" name="_method" value="put">
		{{csrf_field()}}
		<table class="add_tab">
			<tbody>
                <tr>
                    <th><i class="require">*</i>名称：</th>
                    <td>
                        <input type="text" size="50" name="links_name" value="{{$field->links_name}}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>地址：</th>
                    <td>
                        <input type="text" size="50" name="links_url" value="{{$field->links_url}}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>说明：</th>
                    <td>
                        <input type="text" size="50" name="links_explain" value="{{$field->links_explain}}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>排序：</th>
                    <td>
                        <input type="text" size="50" name="links_order" value="{{$field->links_order}}">
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
