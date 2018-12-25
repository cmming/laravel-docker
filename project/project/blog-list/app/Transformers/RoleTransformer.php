<?php

/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2018/11/14
 * Time: 11:59
 */

namespace App\Transformers;

use App\Models\Role;
use League\Fractal\TransformerAbstract;


class RoleTransformer extends TransformerAbstract
{
    public function transform(Role $role)
    {
        return $role->attributesToArray();
    }

}