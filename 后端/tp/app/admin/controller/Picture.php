<?php

namespace app\admin\controller;


use think\Exception;
use think\facade\Validate;
use think\Request;
use think\response\Json;
use app\admin\model\Pictures;

class Picture
{
    /**
     * 获取所有图片列表
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
            $total = Pictures::where($searchField,'like',"%${searchValue}%")->order($sortField,$sortValue)->count();
            $data = Pictures::where($searchField,'like',"%${searchValue}%")->order($sortField,$sortValue)->limit($page * $size,$size)->select();
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
     * 添加图片数据
     *
     * @param Request $request
     * @return Json
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
        if ($request->post('id',false)){
            return echoJson(201,'非法添加图片');
        }
        $photoAlbum = new Pictures();
        $data = $request->all();
        try {
            if ($photoAlbum->save($data)){
                return echoJson(200,"图片添加成功");
            }
            return echoJson(201,"图片添加失败");
        }catch (Exception $e){
            return echoJson(201,$e->getMessage());
        }
    }

    /**
     * 更新图片数据
     *
     * @param Request $request
     * @return Json
     */
    public function put(Request $request): Json
    {
        $validate = Validate::rule([
            'id|ID'=>'require|max:10|min:1|number',
        ]);
        if (!$validate->check($request->all())) {
            return echoJson(201,$validate->getError());
        }
        try {
            $data = $request->all();
            $cacheData = Pictures::find($data['id']);
            if ($cacheData){
                foreach ($data as $name=>$value) {
                    $cacheData[$name] = $value;
                }
                if ($cacheData->save()){
                    return echoJson(200,"图片更新成功");
                }
            }
            return echoJson(201,"图片更新失败");
        }catch (Exception $e){
            return echoJson(201,$e->getMessage());
        }
    }

    /**
     * 删除图片数据
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
            $data = Pictures::find($request->delete('id'));
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