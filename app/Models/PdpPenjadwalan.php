<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PdpPenjadwalan extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;
    public $incrementing = false;
    protected $table = "pdp_penjadwalan";
    protected $primaryKey = "uuid";
    protected $keyType = 'string';
    protected $cascadeDeletes = ['RelPdpDataPetugas'];
    protected $dates = ['deleted_at'];
    protected $guarded = [];
    protected $hidden = [
        "uuid_created",
        "uuid_updated",
        "uuid_deleted",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    public function RelPermohonanPeneraan()
    {
        return $this->belongsTo('App\Models\PermohonanPeneraan', 'uuid_permohonan', 'uuid')->withTrashed();
    }

    public function RelMasterKelompokUttp()
    {
        return $this->belongsTo('App\Models\MasterKelompokUttp', 'uuid_kelompok_uttp', 'uuid')->withTrashed();
    }

    public function RelDiproses()
    {
        return $this->belongsTo('App\Models\Pegawai', 'uuid_diproses', 'uuid')->withTrashed();
    }

    public function RelDitunda()
    {
        return $this->belongsTo('App\Models\Pegawai', 'uuid_ditunda', 'uuid')->withTrashed();
    }

    public function RelDibatalkan()
    {
        return $this->belongsTo('App\Models\Pegawai', 'uuid_dibatalkan', 'uuid')->withTrashed();
    }

    public function RelSelesai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'uuid_selesai', 'uuid')->withTrashed();
    }

    public function RelPdpDataPetugas()
    {
        return $this->hasMany('App\Models\PdpDataPetugas', 'uuid_penjadwalan', 'uuid');
    }
}
