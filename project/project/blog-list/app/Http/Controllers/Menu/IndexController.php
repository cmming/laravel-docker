<?php

namespace App\Http\Controllers\Menu;

use App\Transformers\MenuTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Menu;

class IndexController extends Controller
{
    //
    private $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    public function index()
    {
        //一级菜单
        $oneMenu = $this->menu->where('parent_id', '=', 0)->get()->toArray();

        foreach ($oneMenu as $key => $menu) {
            //二级
            $oneMenu['children'] = $this->menu->where('parent_id', '=', $menu['id'])->get()->toArray();
        }

        return $oneMenu;
    }

    public function show($id)
    {
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|exists:menus,id',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $user = $this->menu->find($id);
        return $this->response->item($user, new MenuTransformer());
    }

    public function store(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'parent_id' => 'required',
            'show' => 'required',
            'path' => 'required|string',
            'name' => 'required|string',
            'component' => 'required|string',
            'en_title' => 'required|string',
            'zh_title' => 'required|string',
            'icon' => 'required|string',
            'no_cache' => 'required',
            'sort' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $newMenu = [
            'parent_id' => $request->input('parent_id'),
            'show' => $request->input('show'),
            'path' => $request->input('path'),
            'name' => $request->input('name'),
            'component' => $request->input('component'),
            'en_title' => $request->input('en_title'),
            'zh_title' => $request->input('zh_title'),
            'icon' => $request->input('icon'),
            'no_cache' => $request->input('no_cache'),
            'sort' => $request->input('sort'),
        ];

        $menu = $this->menu->create($newMenu);

        return $this->response->created();
    }


    public function update($id, Request $request)
    {
        $validator = \Validator::make(request()->all() + ['id' => $id], [
            'id' => 'required|exists:menus,id',
            'parent_id' => 'required',
            'show' => 'required',
            'path' => 'required|string',
            'name' => 'required|string',
            'component' => 'required|string',
            'en_title' => 'required|string',
            'zh_title' => 'required|string',
            'icon' => 'required|string',
            'no_cache' => 'required',
            'sort' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $newMenu = [
            'parent_id' => $request->input('parent_id'),
            'show' => $request->input('show'),
            'path' => $request->input('path'),
            'name' => $request->input('name'),
            'component' => $request->input('component'),
            'en_title' => $request->input('en_title'),
            'zh_title' => $request->input('zh_title'),
            'icon' => $request->input('icon'),
            'no_cache' => $request->input('no_cache'),
            'sort' => $request->input('sort'),
        ];
        $this->menu->find($id)->update($newMenu);

        return $this->response->noContent();
    }


    /**
     * 删除路由 删除父层的目录 其下级的菜单会自动消失
     * @param $id
     */
    public function delete($id)
    {
        $validator = \Validator::make(['id'=>$id], [
            'id' => 'required|exists:menus,id',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $this->menu->find($id)->delete();
    }
}
