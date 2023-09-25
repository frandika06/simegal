<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysLogin extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "sys_login";
    protected $primaryKey = "uuid";
    protected $keyType = 'string';
    protected $guarded = [];

    public function Publisher()
    {
        return $this->belongsTo('App\Models\Pegawai', 'uuid_profile', 'uuid')->withTrashed();
    }
}
