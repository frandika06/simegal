<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysLogAktifitas extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "sys_log_aktifitas";
    protected $primaryKey = "uuid";
    protected $keyType = 'string';
    protected $guarded = [];
}
