<?php

namespace App\Exports;

use App\Models\Log;
//use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LogsExport implements FromCollection,ShouldQueue,WithHeadings,ShouldAutoSize
{
//    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Log::all(['method','operation','params','response','created_at']);
    }

    public function headings(): array
    {
        return ['请求方式','操作','参数','响应数据','请求时间'];
    }
}
