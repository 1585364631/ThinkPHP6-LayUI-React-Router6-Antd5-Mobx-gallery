<?php

namespace app\home\controller;

use app\admin\model\PhotoAlbum;
use app\admin\model\Pictures;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\facade\Validate;
use think\Request;
use think\response\Json;

class Picture
{
    /**
     * 获取所有图片列表
     *
     * @param Request $request
     * @return Json
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function get(Request $request)
    {
        $id = $request->all('id',false);
        $photoAlbum = new PhotoAlbum();
        if (empty($id)){
            return json([
                "code"=>200,
                "data"=>$photoAlbum::where('user_id',$request->uid)->with('pictures')->select()->toArray()
            ]);
        }
        return json([
            "code"=>200,
            "data"=>$photoAlbum::where('user_id',$request->uid)->where("id",$id)->with('pictures')->hidden(['user_id'])->select()->toArray()
        ]);
    }

    /**
     * 添加图片数据
     *
     * @param Request $request
     * @return Json
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function post(Request $request): Json
    {
        $validate = Validate::rule([
            'photoid|所属相册ID'=>'require|max:20|min:1',
            'name|图片名'=>'max:20|min:1|chsDash',
            'url|图片地址'=>'require',
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        if(!empty(PhotoAlbum::where("id",$request->all('photoid'))->where("user_id",$request->uid)->select()->toArray())){
            $photo = new Pictures();
            $data = $request->only(['url','name','text','photoid']);
            try {
                if ($photo->save($data)){
                    return echoJson(200,"图片上传成功");
                }
                return echoJson(201,"图片上传失败");
            }catch (Exception $e){
                return echoJson(201,$e->getMessage());
            }
        }
        return echoJson(201,"非法操作");
    }

    /**
     * 更新图片数据
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
            'name|图片名'=>'max:20|min:1|chsDash',
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        try {
            $data = $request->only(['id','name','text',"photoid"]);
            $photo = new Pictures();
            if (!empty($photo->find($data['id'])->photoAlbum()->where('user_id',$request->uid)->select()->toArray())){
                $cacheData = $photo::find($data['id']);
                if ($cacheData){
                    if (!empty($data['photoid'])){
                        if (empty(PhotoAlbum::where("id",$data['photoid'])->where("user_id",$request->uid)->select()->toArray())){
                            return echoJson(201,"非法操作");
                        }
                    }
                    foreach ($data as $name=>$value) {
                        $cacheData[$name] = $value;
                    }
                    if ($cacheData->save()){
                        return echoJson(200,"图片更新成功");
                    }
                    return echoJson(200,"图片更新失败");
                }
            }
            return echoJson(201,"非法操作");
        }catch (Exception $e){
            return echoJson(201,$e->getMessage());
        }
    }

    /**
     * 删除图片数据
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
            $id = $request->all('id');
            $photo = new Pictures();
            if (!empty($photo->find($id)->photoAlbum()->where('user_id',$request->uid)->select()->toArray())){
                if (Pictures::find($id)->delete()){
                    return echoJson(200,"删除成功");
                }
                return echoJson(201,"删除失败");
            }
            return echoJson(201,"非法操作");
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