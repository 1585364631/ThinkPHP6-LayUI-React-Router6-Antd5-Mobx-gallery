<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\model\Users;
use think\Exception;
use think\facade\Validate;
use think\Request;
use think\response\Json;

class User
{
    /**
     * 获取所有用户列表
     *
     * @param Request $request
     * @return Json
     */
    public function get(Request $request): Json
    {
        $validate = Validate::rule([
            'size|每页个数'=>'number',
            'page|当前页数'=>'number',
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        $page = $request->get('page',1) - 1;
        $size = $request->get('size',10);
        $searchField = $request->get('searchfield',"id");
        $searchValue = $request->get('searchvalue',"");
        $sortField = $request->get('sortfield',"id");
        $sortValue = $request->get('sortvalue',"asc");
        if (empty($searchField)){
            $searchField = 'id';
        }
        try {
            $total = Users::where($searchField,'like',"%${searchValue}%")->order($sortField,$sortValue)->count();
            $data = Users::where($searchField,'like',"%${searchValue}%")->order($sortField,$sortValue)->limit($page * $size,$size)->select();
            return json([
               'code' => 200,
               'total' => $total,
               'data' => $data
            ]);
        } catch (Exception $e) {
            return echoJson(201,$e->getMessage());
        }

    }

    /**
     * 添加新用户
     *
     * @param Request $request
     * @return Json
     */
    public function post(Request $request): Json
    {
        $validate = Validate::rule([
            'number|账号'=>'require|max:20|min:5|unique:users',
            'password|密码'=>'require|max:20|min:5',
            'username|用户名'=>'max:20|min:5|chsDash|unique:users',
            'email|邮箱'=>'email',
//            'head_img|头像'=>'url',
            'sex|性别'=>'number|between:0,2',
            'address|地址'=>'chsDash',
            'birthday|出生日期'=>'dateFormat:Y-m-d|after:-88 year|before:-1 day',
            'resume|简介'=>'max:500',
            'ip|IP地址'=>'ip',
            'register_time|注册时间'=>'dateFormat:y-m-d h:i:s',
            'login_time|登入时间'=>'dateFormat:y-m-d h:i:s'
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }

        if ($request->post('id',false)){
            return echoJson(201,'非法创建用户');
        }
        $users = new Users();
        $data = $request->all();
        $data['password'] = md5($data['password']);
        if ($request->post('username',true)){
            $data['username'] = getUserNumber();
        }
        try {
            if ($users->save($data)){
                return echoJson(200,"注册成功");
            }
            return echoJson(201,"注册失败");
        }catch (Exception $e){
            return echoJson(201,$e->getMessage());
        }
    }

    /**
     * 更新用户数据
     *
     * @param Request $request
     * @return Json
     */
    public function put(Request $request): Json
    {
        $validate = Validate::rule([
            'id|ID'=>'require|max:10|min:1|number',
            'number|账号'=>'max:20|min:5|unique:users',
            'password|密码'=>'min:5',
            'username|用户名'=>'max:20|min:5|chsDash|unique:users',
            'email|邮箱'=>'email',
//            'head_img|头像'=>'url',
            'sex|性别'=>'number|between:0,2',
            'address|地址'=>'chsDash',
            'birthday|出生日期'=>'dateFormat:Y-m-d|after:-88 year|before:-1 day',
            'resume|简介'=>'max:500',
            'ip|IP地址'=>'ip',
//            'register_time|注册时间'=>'dateFormat:y-m-d h:i:s',
//            'login_time|登入时间'=>'dateFormat:y-m-d h:i:s'
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        try {
            $data = $request->all();
            $cacheData = Users::find($data['id']);
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

    /**
     * 删除用户数据
     *
     * @param Request $request
     * @return Json
     */
    public function delete(Request $request): Json
    {
        $validate = Validate::rule([
            'id|ID'=>'require|max:10|min:1|number'
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        try {
            $data = Users::find($request->delete('id'));
            if ($data && $data->delete()){
                return echoJson(200,"删除成功");
            }
            return echoJson(201,"删除失败");
        }catch (Exception $e){
            return echoJson(201,$e->getMessage());
        }
    }

    /**
     * REST类型接口
     *
     * @param Request $request
     * @return Json
     */
    public function index(Request $request): Json
    {
        if($request->isGet()){
            return $this->get($request);
        }
        if($request->isPost()){
            return $this->post($request);
        }
        if($request->isPut()){
            return $this->put($request);
        }
        if($request->isDelete()){
            return $this->delete($request);
        }
        return echoJson(201,'非法请求');
    }
}
