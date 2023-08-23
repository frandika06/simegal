<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysResetPassword extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "password_resets";
    protected $keyType = 'string';
    protected $guarded = [];
}
