@extends('Layouts/adminLayout')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
	<!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
	<i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部分类
</div>
<!--面包屑导航 结束-->

<!--结果页快捷搜索框 开始-->
<div class="search_wrap">
	<form action="" method="post">
		<table class="search_tab">
			<tr>
				<th width="120">选择分类:</th>
				<td>
					<select onchange="javascript:location.href=this.value;">
						<option value="0">全部</option>
						@foreach($data as $value)
						<option value="{{$value->category_id}}">{{$value->category_name}}</option>
						@endforeach
					</select>
				</td>
				<th width="70">关键字:</th>
				<td><input type="text" name="keywords" placeholder="关键字"></td>
				<td><input type="submit" name="sub" value="查询"></td>
			</tr>
		</table>
	</form>
</div>
<!--结果页快捷搜索框 结束-->

<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
	<div class="result_wrap">
		<!--快捷导航 开始-->
		<div class="result_content">
			<div class="short_wrap">
				<a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>新增分类</a>
				<a href="#"><i class="fa fa-recycle"></i>批量删除</a>
				<a href="#"><i class="fa fa-refresh"></i>更新排序</a>
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
					<th class="tc">标题</th>
					<th class="tc">地址</th>
					<th class="tc">点击</th>
					<th class="tc">发布人</th>
					<th class="tc">操作</th>
				</tr>
				@foreach($data as $value)
				<tr>
					<td class="tc">
						<input type="text" onchange="changeOrder(this,{{$value->category_id}})" name="ord[]" value="{{$value->category_order}}">
					</td>
					<td class="tc">{{$value->category_id}}</td>
					<td class="tc">
						<a href="#">{{$value->category_name}}</a>
					</td>
					<td class="tc"><a href="{{$value->category_url}}">{{$value->category_url}}</a></td>
					<td class="tc">{{$value->category_view}}</td>
					<td class="tc">admin</td>
					<td class="tc">
						<a href="{{url('admin/category/'.$value->category_id.'/edit')}}">修改</a>
						<a href="javascript:;" onclick="del({{$value->category_id}})">删除</a>
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
	function changeOrder(obj,category_id){
		var order_id = $(obj).val();
		$.post("{{url('admin/category_order')}}",{'_token':'{{csrf_token()}}','category_id':category_id,'category_order':order_id},function(data){
			if (data.status==1) {
				layer.msg(data.msg,{icon:6});
			}else{
				layer.msg(data.msg,{icon:5});
			}
		})
	};
	//删除分类
	function del(category_id){
		layer.confirm('您确定要删除该分类吗？', {
			btn: ['确定','取消'] //按钮
		}, function(){
			$.post("{{url('admin/category')}}/"+category_id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
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
