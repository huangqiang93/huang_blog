<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function info()
    {
        return view('admin.info');
    }

    public function changepass()
    {
        if ($input = Input::all()) {
            $rules = [
                'new_password'=>'required|between:6,20|confirmed',
            ];
            $message = [
                'new_password.required'=>'新密码不能为空！',
                'new_password.between'=>'新密码必须在6-20位之间！',
                'new_password.confirmed'=>'两次输入新密码不一致！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if ($validator->passes()) {
                $user = User::first();
                $old_pass = Crypt::decrypt($user->user_password);
                if ($old_pass == $input['old_password']) {
                    $user->user_password = Crypt::encrypt($input['new_password']);
                    $user->update();
                    return back()->withErrors($validator->errors()->add('errors','密码修改成功！'));
                }else{
                    return back()->withErrors($validator->errors()->add('errors','原密码错误！'));
                }
            }else{
                return back()->withErrors($validator);
            }

        }else{
            return view('admin.changepass');
        }

    }
}
