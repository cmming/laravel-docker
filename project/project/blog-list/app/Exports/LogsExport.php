<?php

namespace App\Exports;

use App\Models\Log;
//use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;

class LogsExport implements FromCollection,ShouldQueue
{
//    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Log::all(['method','created_at']);
    }
}
