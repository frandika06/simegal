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
    protected $cascadeDeletes = ['RelPdpDataPetugas', 'RelPdpRetribusi'];
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

    public function RelGetPetugasTAP()
    {
        $result = $this->RelPdpDataPetugas();
        $result = $result->where("jabatan_petugas", "Tenaga Ahli Penera")->with("RelPegawai");
        return $result;
    }

    public function RelGetPetugasPT()
    {
        $result = $this->RelPdpDataPetugas();
        $result = $result->where("jabatan_petugas", "Pendamping Teknis")->with("RelPegawai");
        return $result;
    }

    // INSTRUMEN DAN ALAT
    // instrumen
    public function RelPdpInstrumen()
    {
        return $this->hasMany('App\Models\PdpInstrumen', 'uuid_penjadwalan', 'uuid');
    }
    // instrumen order by
    public function RelPdpInstrumenOrder()
    {
        $result = $this->RelPdpInstrumen();
        $result = $result->orderBy("no_urut", "ASC");
        return $result;
    }
    // retribusi
    public function RelPdpRetribusi()
    {
        return $this->hasOne('App\Models\PdpRetribusi', 'uuid_penjadwalan', 'uuid');
    }
    // alat
    public function RelPdpAlat()
    {
        return $this->hasMany('App\Models\PdpAlat', 'uuid_penjadwalan', 'uuid');
    }
    // alat order by
    public function RelPdpAlatOrder()
    {
        $result = $this->RelPdpAlat();
        $result = $result->orderBy("no_urut", "ASC");
        return $result;
    }

    // Tindak Lanjut
    // Manajemen SKHP
    public function RelTteSkhp()
    {
        return $this->hasOne('App\Models\TteSkhp', 'uuid_penjadwalan', 'uuid');
    }
    // Manajemen File Cerapan
    public function RelFileCerapan()
    {
        return $this->hasMany('App\Models\PdpFileCerapan', 'uuid_penjadwalan', 'uuid');
    }
    // Manajemen File Ba
    public function RelFileBa()
    {
        return $this->hasMany('App\Models\PdpFileBa', 'uuid_penjadwalan', 'uuid');
    }
}