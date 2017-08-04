<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

require_once 'resources/captcha/Code.class.php';

class LoginController extends Controller
{
    public function login()
    {
        if ($input = Input::all()) {
            $captcha = new \Code;
            $checkCaptcha = $captcha->get();
            if (strtoupper($input['captcha']) != $checkCaptcha) {
                return back()->with(session(['message'=>'验证码错误']));
            }
            $user = User::first();
            if ($user->user_name != $input['username']) {
                return back()->with(session(['message'=>'用户名错误，不存在该用户！']));
            }else if(Crypt::decrypt($user->user_password) != $input['password']){
                return back()->with(session(['message'=>'密码错误']));
            }
            session(['user'=>$user]);
            return redirect('admin/index');
        }else{
            return view('admin.login');
        }

    }

    //验证码图片
    public function captcha()
    {
        $captcha = new \Code;
        return $captcha->make();
    }

    public function logout()
    {
        session(['user'=>null]);
        return redirect('admin/login');
    }




}
