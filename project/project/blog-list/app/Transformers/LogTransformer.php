<?php
/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2018/12/24
 * Time: 18:56
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Log;

class LogTransformer extends TransformerAbstract
{

    public function transform(Log $log)
    {
        return $log->attributesToArray();
    }
}