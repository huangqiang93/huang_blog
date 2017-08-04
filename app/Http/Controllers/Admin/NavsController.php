<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Model\Navs;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class NavsController extends Controller
{
    public function index()
    {
        $navs = Navs::orderBy('navs_order')->get();
        return view('admin.navs_list')->with('navs',$navs);
    }

    public function changeorder()
    {
        $input=Input::all();
        $links = Links::find($input['links_id']);
        $links->links_order = $input['links_order'];
        $res = $links->update();
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

    public function create()
    {
        return view('admin.navs_add');
    }

    public function store()
    {
        $input = Input::except('_token');
        if ($input = Input::all()) {
            $rules = [
                'navs_name'=>'required',
                'navs_url'=>'required',
            ];
            $message = [
                'navs_name.required'=>'导航名称不能为空！',
                'navs_url.required'=>'导航地址不能为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if ($validator->passes()) {
                $res = Navs::create($input);
                if ($res) {
                    $data = [
                        'status'=>1,
                        'msg'=>'添加分类成功！'
                    ];
                    return $data;
                }else{
                    $data = [
                        'status'=>0,
                        'msg'=>'添加分类失败！'
                    ];
                    return $data;
                }
            }else{
                $data = [
                    'status'=>0,
                    'msg'=>'分类名称不能为空！'
                ];
                return $data;
            }
        }
    }

    public function edit($navs_id)
    {
        $field = Navs::find($navs_id);
        return view('admin.navs_edit',compact('field'));
    }

    public function update($navs_id)
    {
        $input = Input::except('_method','_token');
        $res = Navs::where('navs_id',$navs_id)->update($input);
        if ($res) {
            return redirect('admin/navs');
        }else{
            return back()->with('errors','更新分类失败！');
        }

    }

    public function destroy($links_id)
    {
        $res = Links::where('links_id',$links_id)->delete();
        if ($res) {
            $data = [
                'status'=>1,
                'msg'=>'删除分类成功！'
            ];
            return $data;
        }else{
            $data = [
                'status'=>0,
                'msg'=>'删除分类失败！'
            ];
            return $data;
        }
    }
}
