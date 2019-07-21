<?php

namespace App\Http\Controllers\Router;

use App\Http\Controllers\Controller;
use App\Models\Router;
use App\Models\RouterRel;
use App\Transformers\RouterTransformer;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2019/7/10
 * Time: 18:25
 */
class IndexController extends Controller
{

    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }


    public function index()
    {
        $all_router = \DB::select("SELECT * FROM routers ORDER BY sort DESC");


        $tree = $this->getTree($all_router, 0);

//        $routers = $this->router->where('parent_id', '=', 0)->orderBy('sort', 'desc')->get()->toArray();
//
//        $tree = $this->delSonRouter($routers);
//
        return $tree;

    }


    private function getTree($data, $pId){
        $tree = [];
        foreach($data as $k => $v)
        {
            if($v->parent_id == $pId)
            {         //父亲找到儿子
                $v->children = $this->getTree($data, $v->id);
                $tree[] = $v;
            }
        }
        return $tree;
    }

    private function createSonRouter($routers){

    }

    private function delSonRouter($routers)
    {

        $tree = [];

        foreach ($routers as $key => $router) {
            //
            $son_routers = $this->router->find($router['id'])->son_routers()->orderBy('sort', 'desc')->get()->toArray();
            if (count($son_routers)) {
                $router['children'] = $son_routers;
                $this->delSonRouter($son_routers);
                $tree[] = $router;
            }
        }

        return $tree;
    }

    public function show($id)
    {
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|exists:routers,id',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $router = $this->router->find($id);
        return $this->response->item($router, new RouterTransformer());
    }

    public function store(Request $request)
    {
        $canEmptyPam = $this->noMustHas(
            array(
                array('parent_id' => 'numeric'),
            )
        );

        $parent_id = isset($canEmptyPam['parent_id']) ? $canEmptyPam['parent_id'] : '';

        $validator = \Validator::make(request()->all(), [
            'path' => 'required|string',
            'component' => 'required|string',
            'name' => 'required|unique:routers,name',
            'title' => 'required|string',
            'icon' => 'required|string',
            'type' => 'required|numeric',
            'hidden' => 'required|numeric',
            'model' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $data = request(['parent_id', 'path', 'component', 'name', 'title', 'icon', 'type', 'hidden', 'model','sort']);

        if ($parent_id != '' && $parent_id != 0) {
            //插入一条关系表  找到 父路由的模型，进行 模型保存
//            dd(request(['parent_id', 'hidden', 'path', 'name', 'component', 'title', 'zhTitle', 'icon', 'noCache']));
            $router = $this->router->create($data);
            $res = $this->router->find($parent_id)->add_son_router($router);
        } else {
            $router = $this->router->create($data);

        }

        return $this->response->created();
    }

    public function update($id)
    {
        $canEmptyPam = $this->noMustHas(
            array(
                array('parent_id' => 'numeric'),
            )
        );
        $parent_id = isset($canEmptyPam['parent_id']) ? $canEmptyPam['parent_id'] : '';
        $validator = \Validator::make(['id' => $id] + request()->all(), [
            'id' => 'required|numeric|exists:routers,id',
            'path' => 'required|string',
            'component' => 'required|string',
            'name' => 'required',
            'title' => 'required|string',
            'icon' => 'required|string',
            'type' => 'required|numeric',
            'hidden' => 'required|numeric',
            'sort' => 'required|numeric',
            'model' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $update_router = $this->router->find($id);
        $parent_router = $update_router->parent_routers->toArray();
        $old_parent_id = isset($parent_router[0]) ? $parent_router[0]['id'] : '';

        $data = request(['parent_id', 'path', 'component', 'name', 'title', 'icon', 'type', 'hidden', 'model','sort']);
        $router = $update_router->update($data);
        if ($old_parent_id != '' && $old_parent_id != $parent_id) {
            $this->router->find($old_parent_id)->delete_son_router($update_router);
            $this->router->find($parent_id)->add_son_router($update_router);
        }

        return $this->response->noContent();

    }

    public function destroy(Request $request)
    {
        $ids = $request->get('id');
        foreach ($ids as $id) {
            $validator = \Validator::make(['id' => $id], [
                'id' => 'required|numeric|exists:routers,id',
            ]);
        }
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        foreach ($ids as $id) {
            // 删除关系表中的数据
            RouterRel::where('parent_id', '=', $id)->orWhere('son_id', '=', $id)->delete();
            $this->router->destroy($id);
        }

        return $this->response->noContent();

    }


}