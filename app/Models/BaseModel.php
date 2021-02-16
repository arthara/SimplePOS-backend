<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    // hide certain columns from returned data
    protected $hidden = ['created_at', 'updated_at'];
}
