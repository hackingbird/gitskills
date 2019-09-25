<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class SessionsController extends Controller
{
    //
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
       $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
       ]);
//validate 方法接收两个参数，第一个参数为用户的输入数据，第二个参数为该输入数据的验证规则

//attempt 方法会接收一个数组来作为第一个参数，该参数提供的值将用于寻找数据库中的用户数据
if (Auth::attempt($credentials, $request->has('remember'))) {
    
    session()->flash('success', '欢迎回来！');
    return redirect()->route('users.show', [Auth::user()]);
    
} else {
    // 登录失败后的相关操作
    session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
    return redirect()->back()->withInput();
    //跳转到上个页面，并携带错误信息
}

       return;
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }

}
