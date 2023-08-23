<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysFailedLogin extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "sys_failed_login";
    protected $primaryKey = "uuid";
    protected $keyType = 'string';
    protected $guarded = [];
}
