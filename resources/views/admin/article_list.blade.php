@extends('Layouts/adminLayout')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
	<!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
	<i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部文章
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
				<a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
				<a href="#"><i class="fa fa-recycle"></i>批量删除</a>
			</div>
		</div>
		<!--快捷导航 结束-->
	</div>

	<div class="result_wrap">
		<div class="result_content">
			<table class="list_tab">
				<tr>
					<th class="tc" width="5%"><input type="checkbox" name=""></th>
					<th class="tc">ID</th>
					<th class="tc">缩略图</th>
					<th class="tc">标题</th>
					<th class="tc">发布人</th>
					<th class="tc">发布时间</th>
					<th class="tc">阅读数</th>
					<th class="tc">操作</th>
				</tr>
				@foreach($data as $value)
				<tr>
					<td class="tc"><input type="checkbox" name="id[]" value="59"></td>
					<td class="tc">{{$value->article_id}}</td>
					<td class="tc"><img src="/{{$value->article_thumb}}" style="max-width:60px;max-height:50px;margin-button:-10px"></td>
					<td class="tc">
						<a href="/article/{{$value->article_id}}" target="_blank">{{$value->article_title}}</a>
					</td>
					<td class="tc">{{$value->article_author}}</td>
					<td class="tc">{{date('Y-m-d',$value->article_addtime)}}</td>
					<td class="tc">{{$value->article_views}}</td>
					<td class="tc">
						<a href="{{url('admin/article/'.$value->article_id.'/edit')}}">修改</a>
						<a href="javascript:;" onclick="del({{$value->article_id}})">删除</a>
					</td>
				</tr>
				@endforeach
			</table>


<div class="page_nav">
</div>
			<div class="page_list">
				{{$data->links()}}
			</div>
		</div>
	</div>
</form>
<style>
	.resule_content ul li span{
		font-size: 15px;
		padding:6px 12px;
	}
</style>
<script type="text/javascript">
	//删除分类
	function del(article_id){
		layer.confirm('您确定要删除该文章吗？', {
			btn: ['确定','取消'] //按钮
		}, function(){
			$.post("{{url('admin/article')}}/"+article_id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
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
