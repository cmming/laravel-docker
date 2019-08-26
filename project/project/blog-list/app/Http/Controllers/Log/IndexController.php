<?php
namespace App\Http\Controllers\Log;


use App\Exports\LogsExport;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Transformers\LogTransformer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2019/7/22
 * Time: 17:40
 */
class IndexController extends Controller
{

    private $log;

    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function index(Request $request)
    {
//        $roles = $this->log->filter($request->all())->paginate();
        $roles = $this->log->search($request->get('key_word'))->paginate(15);

        return $this->response->paginator($roles, new LogTransformer());
    }

    public function delete($id){
        $this->log->find($id)->delete();
        return $this->response->noContent();
    }

    public function export()
    {
        set_time_limit(0);
        header('Access-Control-Expose-Headers:Content-Disposition');
        return Excel::download(new LogsExport(), 'logs.xlsx');
    }
}