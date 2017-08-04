<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Model\Config;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    public function index()
    {
        $data = Config::orderBy('conf_order','asc')->get();
        foreach ($data as $key => $value) {
            switch ($value->field_type) {
                case 'input':
                    $data[$key]->html = "<input type='text' class='lg' name='conf_content[]' value='".$value->conf_content."'>";
                    break;
                case 'textarea':
                    $data[$key]->html = "<textarea type='text' class='lg' name='conf_content[]'>".$value->conf_content."</textarea>";
                    break;
                case 'radio':
                    $arr = explode(',',$value->field_value);
                    $html ='';
                    foreach ($arr as $k => $v) {
                        $r = explode('|',$v);
                        $c = $value->conf_content==$r[0]?' checked ':' ';
                        $html .= "<input type='radio' name='conf_content[]' value='".$r[0]."' ".$c.">".$r[1]."　";
                    };
                    $data[$key]->html = $html;
                    break;
            }
        }
        return view('admin.config_list')->with('data',$data);
    }

    public function create()
    {
        $data = Config::orderBy('conf_order','asc')->get();
        return view('admin.config_add')->with('data',$data);
    }

    public function changeorder()
    {
        $input=Input::all();
        $conf = Config::find($input['conf_id']);
        $conf->conf_order = $input['conf_order'];
        $res = $conf->update();
        if ($res) {
            $data = [
                'status'=>1,
                'msg'=>'排序更新成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'排序更新失败！'
            ];
        }
        return $data;
    }

    public function changecontent()
    {
        $input=Input::all();
        foreach ($input['conf_id'] as $key => $value) {
            Config::where('conf_id',$value)->update(['conf_content'=>$input['conf_content'][$key]]);
        };
        $this->conf_cache();
        return back()->with('errors','配置更新成功！');
    }

    public function conf_cache()
    {
        $config = Config::pluck('conf_content','conf_name')->all();
        $path = base_path()."/config/web_conf.php";
        $str = "<?php return ".var_export($config,true).";";
        file_put_contents($path,$str);
    }

    public function store()
    {
        $input = Input::except('_token');
        if ($input = Input::all()) {
            $rules = [
                'conf_title'=>'required',
                'conf_name'=>'required',
            ];
            $message = [
                'conf_title.required'=>'配置标题不能为空！',
                'conf_name.required'=>'配置名称不能为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if ($validator->passes()) {
                $res = Config::create($input);
                if ($res) {
                    $data = [
                        'status'=>1,
                        'msg'=>'添加配置成功！'
                    ];
                    return $data;
                }else{
                    $data = [
                        'status'=>0,
                        'msg'=>'添加配置失败！'
                    ];
                    return $data;
                }
            }else{
                $data = [
                    'status'=>0,
                    'msg'=>'配置名称，标题不能为空！'
                ];
                return $data;
            }
        }
    }

    public function edit($conf_id)
    {
        $field = Config::find($conf_id);
        return view('admin.config_edit',compact('field'));
    }

    public function update($conf_id)
    {
        $input = Input::except('_method','_token');
        $res = Config::where('conf_id',$conf_id)->update($input);
        if ($res) {
            $this->conf_cache();
            return redirect('admin/config');
        }else{
            return back()->with('errors','编辑文章失败！');
        }
    }

    public function destroy($conf_id)
    {
        $res = Config::where('conf_id',$conf_id)->delete();
        if ($res) {
            $this->conf_cache();
            $data = [
                'status'=>1,
                'msg'=>'删除配置成功！'
            ];
            return $data;
        }else{
            $data = [
                'status'=>0,
                'msg'=>'删除配置失败！'
            ];
            return $data;
        }
    }
}
