<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Model\Links;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class LinksController extends Controller
{
    public function index()
    {
        $links = Links::orderBy('links_order')->get();
        return view('admin.links_list')->with('links',$links);
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
        return view('admin.links_add');
    }

    public function store()
    {
        $input = Input::except('_token');
        if ($input = Input::all()) {
            $rules = [
                'links_name'=>'required',
                'links_url'=>'required',
                'links_explain'=>'required'
            ];
            $message = [
                'links_name.required'=>'友链名称不能为空！',
                'links_url.required'=>'友链地址不能为空！',
                'links_explain.required'=>'友链说明不能为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if ($validator->passes()) {
                $res = Links::create($input);
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

    public function edit($links_id)
    {
        $field = Links::find($links_id);
        return view('admin.links_edit',compact('field'));
    }

    public function update($links_id)
    {
        $input = Input::except('_method','_token');
        $res = Links::where('links_id',$links_id)->update($input);
        if ($res) {
            return redirect('admin/links');
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
