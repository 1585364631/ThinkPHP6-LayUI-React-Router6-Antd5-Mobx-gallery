<?php

namespace app\admin\controller;


use think\Exception;
use think\facade\Validate;
use think\Request;
use think\response\Json;
use app\admin\model\PhotoAlbum;

class Photo
{
    /**
     * 获取所有相册列表
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
        if (empty($searchField)){
            $searchField = 'id';
        }
        $searchValue = $request->get('searchvalue',"");
        $sortField = $request->get('sortfield',"id");
        $sortValue = $request->get('sortvalue',"asc");
        if ($searchField==="authority"){
            if ($searchValue==="私密"){
                $searchValue=1;
            }else{
                $searchValue=0;
            }
        }
        try {
            $total = PhotoAlbum::where($searchField,'like',"%${searchValue}%")->order($sortField,$sortValue)->count();
            $data = PhotoAlbum::where($searchField,'like',"%${searchValue}%")->order($sortField,$sortValue)->limit($page * $size,$size)->select();
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
     * 添加新相册数据
     *
     * @param Request $request
     * @return Json
     */
    public function post(Request $request): Json
    {
        $validate = Validate::rule([
            'user_id|所属用户ID'=>'require|max:20|min:1',
            'name|相册名'=>'max:20|min:1|chsDash|require',
            'authority|权限'=>'number|between:0,1',
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        if ($request->post('id',false)){
            return echoJson(201,'非法创建相册');
        }
        $photoAlbum = new PhotoAlbum();
        $data = $request->all();
        try {
            if ($photoAlbum->save($data)){
                return echoJson(200,"相册创建成功");
            }
            return echoJson(201,"相册创建失败");
        }catch (Exception $e){
            return echoJson(201,$e->getMessage());
        }
    }

    /**
     * 更新相册数据
     *
     * @param Request $request
     * @return Json
     */
    public function put(Request $request): Json
    {
        $validate = Validate::rule([
            'id|ID'=>'require|max:10|min:1|number',
            'user_id|所属用户ID'=>'max:20|min:1',
            'name|相册名'=>'max:20|min:1|chsDash',
            'authority|权限'=>'number|between:0,1',
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        try {
            $data = $request->all();
            $cacheData = PhotoAlbum::find($data['id']);
            if ($cacheData){
                foreach ($data as $name=>$value) {
                    $cacheData[$name] = $value;
                }
                if ($cacheData->save()){
                    return echoJson(200,"相册更新成功");
                }
            }
            return echoJson(201,"相册更新失败");
        }catch (Exception $e){
            return echoJson(201,$e->getMessage());
        }
    }

    /**
     * 删除相册数据
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
            $data = PhotoAlbum::find($request->delete('id'));
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
