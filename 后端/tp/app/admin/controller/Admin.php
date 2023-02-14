<?php

namespace app\admin\controller;

use app\admin\model\AdminUsers;
use app\Request;
use think\facade\Validate;
use think\facade\View;
use think\facade\Session;
use think\response\Redirect;

class Admin
{
    public function index(Request $request)
    {
        $sess = $request->session('user',false);
        if($sess && $sess == Session::get('user',false)){
            return redirect(url('index'));
        }
        return View::fetch();
    }

    public function log_out_in(Request $request): Redirect
    {
        $this->logout($request);
        return redirect(url('login'));
    }

    public function login(Request $request): \think\response\Json
    {
        $validate = Validate::rule([
            'username|账号'=>'require|max:20|min:1',
            'password|密码'=>'require|max:20|min:1',
            'captcha|验证码'=>'require|captcha',
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        $userInfo = AdminUsers::where([
            'username'=>$request->all('username'),
            'password'=>md5($request->all('password')),
        ])->findOrEmpty(1);
        if($userInfo->isEmpty()){
            return echoJson(201,'账号或密码错误');
        }
        Session::set('user',$userInfo);
        $userInfo->login_time = getNowDateTime();
        $userInfo->save();
        return echoJson(200,'登入成功');
    }

    public function logout(Request $request,$text = "退出成功"): \think\response\Json
    {
        $sess = $request->session('user',false);
        if($sess && $sess == Session::get('user',false)){
            Session::delete('user');
        }
        return echoJson(200,$text);
    }

    public function resetUserName(Request $request): \think\response\Json
    {
        $validate = Validate::rule([
            'old|旧的账号'=>'require|max:20|min:1',
            'new|新的账号'=>'require|max:20|min:1',
            'captcha|验证码'=>'require|captcha',
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        $username = Session::get('user')->username;
        if ($request->post('old') != $username){
            return echoJson(201,"原始账号不一致");
        }
        if ($request->post('new') == $username){
            return echoJson(201,"账号无需更改");
        }
        $sqlData = Session::get('user');
        $sqlData->username = $request->post('new');
        $sqlData->save();

        return $this->logout($request,'账号修改成功！请重新登录');
    }

    public function resetPassword(Request $request): \think\response\Json
    {
        $validate = Validate::rule([
            'old|旧的密码'=>'require|max:20|min:1',
            'new|新的密码'=>'require|max:20|min:1',
            'captcha|验证码'=>'require|captcha',
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        $password = Session::get('user')->password;
        if (md5($request->post('old')) != $password){
            return echoJson(201,"原始密码不一致");
        }
        if (md5($request->post('new')) == $password){
            return echoJson(201,"密码无需更改");
        }
        $sqlData = Session::get('user');
        $sqlData->password = md5($request->post('new'));
        $sqlData->save();
        return $this->logout($request,'密码修改成功！请重新登录');
    }
}