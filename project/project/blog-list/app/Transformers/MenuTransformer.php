<?php
/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2018/12/24
 * Time: 15:09
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Menu;

class MenuTransformer extends TransformerAbstract
{
    public function transform(Menu $menu)
    {
        return $menu->attributesToArray();
    }
}