<?php

namespace App\Http\Controllers\Api;

use App\Transformers\ApiTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use  App\Models\Api;

class IndexController extends Controller
{
    //
    private $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $apis = $this->api->paginate();

        return $this->response->paginator($apis, new ApiTransformer());
    }

    public function show($id)
    {
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|exists:apis,id',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $api = $this->api->find($id);
        return $this->response->item($api, new ApiTransformer());
    }

    public function store(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'url' => 'required|string',
            'method' => 'required|string',
            'uses' => 'required|string',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $newApi = [
            'url' => $request->input('url'),
            'method' => $request->input('method'),
            'uses' => $request->input('uses'),
            'description' => $request->input('description'),
        ];

        $role = $this->api->create($newApi);

        return $this->response->created();
    }


    public function update($id, Request $request)
    {
        $validator = \Validator::make(request()->all()+ ['id' => $id], [
            'id' => 'required|exists:apis,id',
            'url' => 'required|string',
            'method' => 'required|string',
            'uses' => 'required|string',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $newApi = [
            'url' => $request->input('url'),
            'method' => $request->input('method'),
            'uses' => $request->input('uses'),
            'description' => $request->input('description'),
        ];
        $this->api->find($id)->update($newApi);

        return $this->response->noContent();
    }

    public function delete($id)
    {
        $validator = \Validator::make(['id'=>$id], [
            'id' => 'required|exists:apis,id',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $this->api->find($id)->delete();
    }
}
