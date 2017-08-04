@extends('Layouts/adminLayout')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
	<!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
	<i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 友情链接列表
</div>
<!--面包屑导航 结束-->


<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
	<div class="result_wrap">
		<!--快捷导航 开始-->
		<div class="result_content">
			<div class="short_wrap">
				<a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>添加友情链接</a>
			</div>
		</div>
		<!--快捷导航 结束-->
	</div>

	<div class="result_wrap">
		<div class="result_content">
			<table class="list_tab">
				<tr>
					<th class="tc">排序</th>
					<th class="tc">ID</th>
					<th class="tc">名称</th>
					<th class="tc">地址</th>
					<th class="tc">说明</th>
					<th class="tc">操作</th>
				</tr>
				@foreach($links as $value)
				<tr>
					<td class="tc">
						<input type="text" onchange="changeOrder(this,{{$value->links_id}})" name="ord[]" value="{{$value->links_order}}">
					</td>
					<td class="tc">{{$value->links_id}}</td>
					<td class="tc">{{$value->links_name}}</td>
					<td class="tc"><a href="{{$value->links_url}}">{{$value->links_url}}</a></td>
					<td class="tc">{{$value->links_explain}}</td>
					<td class="tc">
						<a href="{{url('admin/links/'.$value->links_id.'/edit')}}">修改</a>
						<a href="javascript:;" onclick="del({{$value->links_id}})">删除</a>
					</td>
				</tr>
				@endforeach
			</table>


<!-- <div class="page_nav">
<div>
<a class="first" href="/wysls/index.php/Admin/Tag/index/p/1.html">第一页</a>
<a class="prev" href="/wysls/index.php/Admin/Tag/index/p/7.html">上一页</a>
<a class="num" href="/wysls/index.php/Admin/Tag/index/p/6.html">6</a>
<a class="num" href="/wysls/index.php/Admin/Tag/index/p/7.html">7</a>
<span class="current">8</span>
<a class="num" href="/wysls/index.php/Admin/Tag/index/p/9.html">9</a>
<a class="num" href="/wysls/index.php/Admin/Tag/index/p/10.html">10</a>
<a class="next" href="/wysls/index.php/Admin/Tag/index/p/9.html">下一页</a>
<a class="end" href="/wysls/index.php/Admin/Tag/index/p/11.html">最后一页</a>
<span class="rows">11 条记录</span>
</div>
</div>
			<div class="page_list">
				<ul>
					<li class="disabled"><a href="#">&laquo;</a></li>
					<li class="active"><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
					<li><a href="#">&raquo;</a></li>
				</ul>
			</div>
		</div>
	</div> -->
</form>
<script type="text/javascript">
    //更新排序
	function changeOrder(obj,links_id){
		var order_id = $(obj).val();
		$.post("{{url('admin/links_order')}}",{'_token':'{{csrf_token()}}','links_id':links_id,'links_order':order_id},function(data){
			if (data.status==1) {
				layer.msg(data.msg,{icon:6});
			}else{
				layer.msg(data.msg,{icon:5});
			}
		})
	};
	//删除友链
	function del(links_id){
		layer.confirm('您确定要删除该友链吗？', {
			btn: ['确定','取消'] //按钮
		}, function(){
			$.post("{{url('admin/links')}}/"+links_id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
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

		});
	}
</script>
<!--搜索结果页面 列表 结束-->
@endsection
