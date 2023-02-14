<?php

namespace app\home\controller;

use app\admin\model\PhotoAlbum;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\facade\Validate;
use think\Request;
use think\response\Json;

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
        try {
            $data = PhotoAlbum::where('user_id', $request->uid)->hidden(['user_id'])->select()->toArray();
            return json([
                "code"=>200,
                "data"=>$data,
            ]);
        } catch (DataNotFoundException|ModelNotFoundException|DbException $e) {
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
            'name|相册名'=>'max:20|min:1|chsDash|require',
            'authority|权限'=>'number|between:0,1',
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        $photoAlbum = new PhotoAlbum();
        $data = $request->only(['name','authority']);
        $data['user_id'] = $request->uid;
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
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function put(Request $request): Json
    {
        $validate = Validate::rule([
            'id|ID'=>'require|max:10|min:1|number',
            'name|相册名'=>'max:20|min:1|chsDash',
            'authority|权限'=>'number|between:0,1',
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        try {
            $data = $request->only(['id','name','authority']);
            $cacheData = PhotoAlbum::find($data['id']);
            if ($cacheData){
                if ($cacheData->user_id !== $request->uid){
                    return echoJson(201,"非法操作");
                }
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
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
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
            if ($data->user_id !== $request->uid){
                return echoJson(201,"非法操作");
            }
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
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
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