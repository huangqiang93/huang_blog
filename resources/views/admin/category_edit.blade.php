@extends('Layouts/adminLayout')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
	<!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
	<i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="{{url('admin/category')}}">全部分类</a> &raquo; 新增分类
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
	<div class="result_title">
		<h3>编辑分类</h3>
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
	<form action="{{url('admin/category/'.$field->category_id)}}" method="post">
        <input type="hidden" name="_method" value="put">
		{{csrf_field()}}
		<table class="add_tab">
			<tbody>
				<tr>
					<th width="120"><i class="require">*</i>顶级分类：</th>
					<td>
						<select name="category_pid">
							<option value="0">==请选择==</option>
							@foreach($data as $category)
							<option value="{{$category->category_id}}" @if($category->category_id == $field->category_pid) selected @endif>{{$category->category_name}}</option>
							@endforeach
						</select>
					</td>
				</tr>
				<tr>
					<th><i class="require">*</i>分类名称：</th>
					<td>
						<input type="text" name="category_name" value="{{$field->category_name}}">
					</td>
				</tr>
				<tr>
					<th><i class="require">*</i>分类地址：</th>
					<td>
						<input type="text" name="category_url" value="{{$field->category_url}}">
					</td>
				</tr>
				<tr>
					<th><i class="require">*</i>分类排序：</th>
					<td>
						<input type="text" class="sm" name="category_order" value="{{$field->category_order}}">
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
