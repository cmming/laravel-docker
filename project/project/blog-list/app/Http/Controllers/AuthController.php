<?php

namespace App\Http\Controllers;

use App\Events\LoginRemind;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware(['jwt.auth'], ['except' => ['login','captcha.jpg']]);
//        $this->middleware(['auth=>api'], ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {


        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
            'ckey' => 'required',
            'captcha' => 'required|captcha_api:' . $request->input('ckey')
        ], [
            'captcha.required' => '验证码不能为空',
            'captcha.captcha_api' => '请输入正确的验证码',
        ]);

//        $validator = \Validator::make($request->all(), [
//            'name' => 'required',
//            'password' => 'required'
//        ]);

        if ($validator->fails()) {
            // 错误批量处理
            return $this->errorBadRequest($validator);
        }

        $credentials = request(['name', 'password']);

        if (!$token = auth()->attempt($credentials)) {
//            return $this->response->errorBadRequest(\App\Exceptions\ErrorMessage::getMessage(\App\Exceptions\ErrorMessage::PASSWORD_OR_NAME_ERROR));
            return response()->json(\App\Exceptions\ErrorMessage::getMessage(\App\Exceptions\ErrorMessage::PASSWORD_OR_NAME_ERROR), 400);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


    public function info()
    {
//        $all_router = \DB::select("SELECT * FROM routers ORDER BY sort DESC");
        $all_router = auth()->user()->routers();
        array_multisort(array_column($all_router, 'sort'), SORT_DESC, $all_router);
//        dd($all_router);
        $testRouterList = $this->getTree($all_router, 0);

        $result = [
//            "routerList" => [
//                [
//                    "path" => '/admin/dashborad',
//                    "component" => 'layout/index',
//                    "name" => 'dashborad',
//                    "meta" => [
//                        "title" => 'dashborad',
//                        "icon" => 'dashboard',
//                        "type" => "menu",
//                        "hidden" => false,
//                        "model" => 'dashborad'
//                    ],
//                    "children" => [[
//                        "path" => 'index',
//                        "component" => 'moudles/dashborad/views/index',
//                        "name" => 'dashboradIndex',
//                        "meta" => ["title" => 'dashborad', "icon" => 'dashboard', "type" => "menu", "hidden" => false, "model" => 'dashborad']
//                    ]]
//                ],
//                [
//                    "path" => '/admin/ui',
//                    "component" => 'layout/index',
//                    "name" => 'ui',
//                    "meta" => [
//                        "title" => 'ui',
//                        "icon" => 'dashboard',
//                        "type" => "menu", "hidden" => false,
//                        "model" => 'ui'
//                    ],
//                    "children" => [[
//                        "path" => 'form',
//                        "component" => 'moudles/ui/views/form',
//                        "name" => 'form',
//                        "meta" => ["title" => 'form', "icon" => 'dashboard', "type" => "menu", "hidden" => false, "model" => 'ui']
//                    ],
//                        [
//                            "path" => 'table',
//                            "component" => 'moudles/ui/views/table',
//                            "name" => 'table',
//                            "meta" => ["title" => 'table', "icon" => 'dashboard', "type" => "menu", "hidden" => false, "model" => 'ui']
//                        ],
//                        [
//                            "path" => 'file',
//                            "component" => 'moudles/ui/views/file',
//                            "name" => 'file',
//                            "meta" => ["title" => 'file', "icon" => 'dashboard', "type" => "menu", "hidden" => false, "model" => 'ui']
//                        ],
//                        [
//                            "path" => 'imgCropper',
//                            "component" => 'moudles/ui/views/imgCropper',
//                            "name" => 'imgCropper',
//                            "meta" => ["title" => 'imgCropper', "icon" => 'dashboard', "type" => "menu", "hidden" => false, "model" => 'ui']
//                        ]
//                    ]
//                ],
//                [
//                    "path" => '/admin',
//                    "component" => 'layout/index',
//                    "name" => 'user',
//                    "meta" => [
//                        "title" => 'user',
//                        "icon" => 'dashboard',
//                        "type" => "menu", "hidden" => false,
//                        "model" => 'user'
//                    ],
//                    "children" => [[
//                        "path" => 'user',
//                        "component" => 'moudles/user/views/list',
//                        "name" => 'userList',
//                        "meta" => ["title" => 'userList', "icon" => 'dashboard', "type" => "menu", "hidden" => false, "model" => 'user']
//                    ], [
//                        "path" => 'user/store',
//                        "component" => 'moudles/user/views/form',
//                        "name" => 'userStore',
//                        "meta" => ["title" => 'userStore', "icon" => 'dashboard', "type" => "menu", "hidden" => false, "model" => 'user']
//                    ], [
//                        "path" => 'user/update/:id',
//                        "component" => 'moudles/user/views/form',
//                        "name" => 'userUpdate',
//                        "meta" => ["title" => 'userUpdate', "icon" => 'dashboard', "type" => "menu", "hidden" => true, "model" => 'user']
//                    ]]
//                ],
//                [
//                    "path" => '/admin/systemManager',
//                    "component" => 'layout/index',
//                    "name" => 'systemManager',
//                    "meta" => [
//                        "title" => 'systemManager',
//                        "icon" => 'dashboard',
//                        "type" => "menu", "hidden" => false,
//                        "model" => 'systemManager'
//                    ],
//                    "children" => [[
//                        "path" => 'router',
//                        "component" => 'moudles/systemManager/views/router',
//                        "name" => 'routerList',
//                        "meta" => ["title" => 'routerList', "icon" => 'dashboard', "type" => "menu", "hidden" => false, "model" => 'systemManager']
//                    ], [
//                        "path" => 'role',
//                        "component" => 'moudles/systemManager/views/role',
//                        "name" => 'roleList',
//                        "meta" => ["title" => 'roleList', "icon" => 'dashboard', "type" => "menu", "hidden" => false, "model" => 'systemManager']
//                    ],[
//                        "path" => 'role/store',
//                        "component" => 'moudles/systemManager/views/role.form',
//                        "name" => 'storeRole',
//                        "meta" => ["title" => 'storeRole', "icon" => 'dashboard', "type" => "menu", "hidden" => true, "model" => 'systemManager']
//                    ],[
//                        "path" => 'role/update/:id',
//                        "component" => 'moudles/systemManager/views/role.form',
//                        "name" => 'updateRole',
//                        "meta" => ["title" => 'updateRole', "icon" => 'dashboard', "type" => "menu", "hidden" => true, "model" => 'systemManager']
//                    ]]
//                ],
//            ],
            "indexPage" => "/admin/dashborad/index",
            "routerList" => $testRouterList,
            "info" => auth()->user()
        ];

        event(new LoginRemind(auth()->user()));
        return $result;
    }

    private function getTree($data, $pId)
    {
        $tree = [];
        foreach ($data as $k => $v) {
//            if($v->parent_id == $pId)
//            {         //父亲找到儿子
//                $v->children = $this->getTree($data, $v->id);
//                $tree[] = $v;
//            }

            if ($v['parent_id'] == $pId) {         //父亲找到儿子
                $v['children'] = $this->getTree($data, $v['id']);
                $tree[] = $v;
            }
        }
        return $tree;
    }


}