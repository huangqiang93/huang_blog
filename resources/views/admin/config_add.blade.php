@extends('Layouts/adminLayout')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="{{url('admin/config')}}">网站配置</a> &raquo; 添加配置
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加配置</h3>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form id="formData">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>标题：</th>
                        <td>
                            <input type="text" size="50" name="conf_title">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text" size="50" name="conf_name">
                        </td>
                    </tr>
                    <tr>
                        <th>类型：</th>
                        <td>
                            <input type="radio" name="field_type" value="input" onclick="show()">input　
                            <input type="radio" name="field_type" value="textarea" onclick="show()">textarea　
                            <input type="radio" name="field_type" value="radio" onclick="show()">radio　
                        </td>
                    </tr>
                    <tr class="field_value" style="display:none">
                        <th>类型值：</th>
                        <td>
                            <input type="text" size="50" name="field_value">
                            <p><i class="fa fa-exclamation-circle yellow"></i>类型值只有在类型为radio时需要填写，格式为：1|开启,0|关闭</p>
                        </td>
                    </tr>
                    <tr>
                        <th>说明：</th>
                        <td>
                            <textarea name="conf_content" rows="8" cols="80"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text"name="conf_order">
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
    		   url: '{{url("admin/config")}}',
    		   data: data,
    		   success: function (data) {
    			   if (data.status==1) {
    				   layer.msg(data.msg,{icon:6});
    				   setTimeout(function(){
    					   window.location.href="{{url('admin/config')}}";
    				   },2000);
    			   }else{
    				   layer.msg(data.msg,{icon:5});
    			   };
    		   }
       		});
    	})
        function show(){
            var type=$('input[name=field_type]:checked').val();
            if (type == "radio") {
                $('.field_value').show();
            }else{
                $('.field_value').hide();
            }
        }
    </script>
@endsection
