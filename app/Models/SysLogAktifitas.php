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

    public function RelPegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'uuid_profile', 'uuid')->withTrashed();
    }

    public function RelPerusahaan()
    {
        return $this->belongsTo('App\Models\Perusahaan', 'uuid_profile', 'uuid')->withTrashed();
    }
}
