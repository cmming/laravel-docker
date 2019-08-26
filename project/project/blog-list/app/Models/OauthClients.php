<?php
/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2019/5/10
 * Time: 11:12
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OauthClients extends Model
{
    protected $table = "oauth_clients";

    protected $guarded = [];
}