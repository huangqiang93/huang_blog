@extends('Layouts/adminLayout')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
	<!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
	<i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部分类
</div>
<!--面包屑导航 结束-->

<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
	<div class="result_wrap">
		<!--快捷导航 开始-->
		<div class="result_content">
			<div class="short_wrap">
				<a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>新增导航</a>
			</div>
		</div>
		<!--快捷导航 结束-->
	</div>

	<div class="result_wrap">
		<div class="result_content">
			<table class="list_tab">
				<tr>
					<th class="tc" width="5%"><input type="checkbox" name=""></th>
					<th class="tc">排序</th>
					<th class="tc">ID</th>
					<th class="tc">名称</th>
					<th class="tc">别名</th>
					<th class="tc">地址</th>
					<th class="tc">操作</th>
				</tr>
				@foreach($navs as $value)
				<tr>
					<td class="tc"><input type="checkbox" name="id[]" value="59"></td>
					<td class="tc">
						<input type="text" onchange="changeOrder(this,{{$value->navs_id}})" name="ord[]" value="{{$value->navs_order}}">
					</td>
					<td class="tc">{{$value->navs_id}}</td>
					<td class="tc">
						<a href="#">{{$value->navs_name}}</a>
					</td>
					<td class="tc">0</td>
					<td class="tc">admin</td>
					<td class="tc">
						<a href="{{url('admin/navs/'.$value->navs_id.'/edit')}}">修改</a>
						<a href="javascript:;" onclick="del({{$value->navs_id}})">删除</a>
					</td>
				</tr>
				@endforeach
			</table>
</form>
<script type="text/javascript">
	function changeOrder(obj,navs_id){
		var order_id = $(obj).val();
		$.post("{{url('admin/navs_order')}}",{'_token':'{{csrf_token()}}','navs_id':navs_id,'navs_order':order_id},function(data){
			if (data.status==1) {
				layer.msg(data.msg,{icon:6});
			}else{
				layer.msg(data.msg,{icon:5});
			}
		})
	};
	//删除分类
	function del(navs_id){
		layer.confirm('您确定要删除该分类吗？', {
			btn: ['确定','取消'] //按钮
		}, function(){
			$.post("{{url('admin/navs')}}/"+category_id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
				if (data.status==1) {
					layer.msg('删除成功', {icon: 1});
					setTimeout(function(){
						location.href = location.href;
					},1000);
				}else{
					layer.msg('删除失败', {icon: 5});
				}
			})
		}, function(){
		    // layer.msg('也可以这样', {
		    // time: 20000, //20s后自动关闭
		    // btn: ['明白了', '知道了']
		//   });
		});
	}
</script>
<!--搜索结果页面 列表 结束-->
@endsection
