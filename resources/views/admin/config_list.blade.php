@extends('Layouts/adminLayout')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
	<!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
	<i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 配置列表
</div>
<!--面包屑导航 结束-->


	<div class="result_wrap">
		<div class="result_title">
            <h3>配置项列表</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    @else
                        <p>{{$errors}}</p>
                    @endif
                </div>
            @endif
        </div>
		<!--快捷导航 开始-->
		<div class="result_content">
			<div class="short_wrap">
				<a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置</a>
			</div>
		</div>
		<!--快捷导航 结束-->
	</div>
<!--搜索结果页面 列表 开始-->
<form action="{{url('admin/config_content')}}" method="post">
	{{csrf_field()}}
	<div class="result_wrap">
		<div class="result_content">
			<table class="list_tab">
				<tr>
					<th class="tc">排序</th>
					<th class="tc">ID</th>
					<th class="tc">标题</th>
					<th class="tc">名称</th>
					<th>内容</th>
					<th class="tc">操作</th>
				</tr>
				@foreach($data as $value)
				<input type="hidden" name="conf_id[]" value="{{$value->conf_id}}">
				<tr>
					<td class="tc">
						<input type="text" onchange="changeOrder(this,{{$value->conf_id}})"  value="{{$value->conf_order}}">
					</td>
					<td class="tc">{{$value->conf_id}}</td>
					<td class="tc">{{$value->conf_title}}</td>
					<td class="tc">{{$value->conf_name}}</td>
					<td>{!! $value->html !!}</td>
					<td class="tc">
						<a href="{{url('admin/config/'.$value->conf_id.'/edit')}}">修改</a>
						<a href="javascript:;" onclick="del({{$value->conf_id}})">删除</a>
					</td>
				</tr>
				@endforeach
			</table>
			<div class="btn_group">
				<input type="submit" value="保存">
				<input type="button" class="back" onclick="history.go(-1)" value="返回">
			</div>
</form>
<script type="text/javascript">
    //更新排序
	function changeOrder(obj,conf_id){
		var order_id = $(obj).val();
		$.post("{{url('admin/config_order')}}",{'_token':'{{csrf_token()}}','conf_id':conf_id,'conf_order':order_id},function(data){
			if (data.status==1) {
				layer.msg(data.msg,{icon:6});
			}else{
				layer.msg(data.msg,{icon:5});
			}
		})
	};
	//删除友链
	function del(conf_id){
		layer.confirm('您确定要删除该配置吗？', {
			btn: ['确定','取消'] //按钮
		}, function(){
			$.post("{{url('admin/config')}}/"+conf_id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
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
