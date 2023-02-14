<?php

namespace app\home\controller;

use app\admin\model\Users;
use app\home\Token;
use Exception;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Request;
use think\facade\Validate;

class User
{

    public function checkLogin(): \think\response\Json
    {
        return echoJson(200,"身份有效");
    }

    public function update(Request $request): \think\response\Json
    {
        $validate = Validate::rule([
            'number|账号'=>'max:20|min:5|unique:users',
            'password|密码'=>'min:5',
            'username|用户名'=>'max:20|min:5|chsDash|unique:users',
            'email|邮箱'=>'email',
            'sex|性别'=>'number|between:0,2',
            'address|地址'=>'chsDash',
            'birthday|出生日期'=>'dateFormat:Y-m-d|after:-88 year|before:-1 day',
            'resume|简介'=>'max:500',
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        try {
            $data = $request->only(['number','password','username','email','sex','address','birthday','resume']);
            $cacheData = Users::find($request->uid);
            if ($request->put('password',false)){
                if ($cacheData['password'] !== $request->put('password')){
                    $data['password'] = md5($data['password']);
                }
            }
            if ($cacheData){
                foreach ($data as $name=>$value) {
                    $cacheData[$name] = $value;
                    if (empty($value) && in_array($name,['birthday','register_time','login_time'])){
                        $cacheData[$name] = null;
                    }
                }
                if ($cacheData->save()){
                    return echoJson(200,"更新成功");
                }
            }
            return echoJson(201,"更新失败");
        }catch (Exception $e){
            return echoJson(201,$e->getMessage());
        }
    }

    public function login(Request $request): \think\response\Json
    {
        $validate = Validate::rule([
            'number|账号'=>'max:20|min:5|require',
            'password|密码'=>'require',
//            'captcha|验证码'=>'require|captcha',
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        try {
            $userInfo = Users::where([
                'number' => $request->all('number'),
                'password' => md5($request->all('password')),
            ])->find();
            if(empty($userInfo)){
                return $this->register($request,true);
            }
            $jwtToken = (new Token())->getToken($userInfo->id);
            $cacheUser = Users::find($userInfo->id);
            $cacheUser->ip = $_SERVER['REMOTE_ADDR'];
            $cacheUser->login_time = getNowDateTime();
            $cacheUser->save();
            return json([
                'code'=>200,
                'msg'=>'登入成功',
                'token'=>$jwtToken
            ]);
        }  catch (DataNotFoundException|ModelNotFoundException|DbException $e) {
            return echoJson(201,$e->getMessage());
        }
    }

    public function register(Request $request,$lock): \think\response\Json
    {
        $validate = Validate::rule([
            'number|账号'=>'require|max:20|min:5|unique:users',
            'password|密码'=>'require|max:20|min:5',
//            'captcha|验证码'=>'require|captcha',
        ]);
        if ($lock){
            $validate = Validate::rule([
                'number|账号'=>'require|max:20|min:5|unique:users',
                'password|密码'=>'require|max:20|min:5',
            ])->message([
                "number.unique"=>"账号密码错误"
            ]);
        }
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        $data = [
            "number" => $request->all("number"),
            "password" => md5($request->all("password")),
            "username" => getUserNumber()
        ];
        try {
            if ((new Users)->save($data)){
                $jwtToken = (new Token())->getToken(Users::where($data)->find()->id);
                return json([
                    'code'=>200,
                    'msg'=>'注册成功',
                    'token'=>$jwtToken
                ]);
            }
            return echoJson(201,"注册失败");
        }catch (Exception $e){
            return echoJson(201,$e->getMessage());
        }
    }

//    public function register(Request $request): \think\response\Json
//    {
//        $validate = Validate::rule([
//            'number|账号'=>'require|max:20|min:5|unique:users',
//            'password|密码'=>'require|max:20|min:5',
//            'captcha|验证码'=>'require|captcha',
//        ]);
//        if (!$validate->check($request->all())) {
//            return echoJson(201,$validate->getError());
//        }
//        $data = [
//            "number" => $request->all("number"),
//            "password" => md5($request->all("password")),
//            "username" => getUserNumber()
//        ];
//        try {
//            if ((new Users)->save($data)){
//                $jwtToken = (new Token())->getToken(Users::where($data)->find()->id);
//                return json([
//                    'code'=>200,
//                    'msg'=>'注册成功',
//                    'token'=>$jwtToken
//                ]);
//            }
//            return echoJson(201,"注册失败");
//        }catch (Exception $e){
//            return echoJson(201,$e->getMessage());
//        }
//    }
}