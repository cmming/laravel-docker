<?php
/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2019/7/10
 * Time: 18:29
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use App\Models\Router;

class RouterTransformer extends TransformerAbstract
{
    public function transform(Router $router)
    {
        return $router->attributesToArray();
    }


}