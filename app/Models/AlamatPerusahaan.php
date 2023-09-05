<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlamatPerusahaan extends Model
{
    use HasFactory, SoftDeletes;
    public $incrementing = false;
    protected $table = "alamat_perusahaan";
    protected $primaryKey = "uuid";
    protected $keyType = 'string';
    protected $guarded = [];
    protected $hidden = [
        "uuid_created",
        "uuid_updated",
        "uuid_deleted",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    public function RelPerusahaan()
    {
        return $this->belongsTo('App\Models\Perusahaan', 'uuid_perushaan', 'uuid')->withTrashed();
    }

    public function Provinsi()
    {
        return $this->belongsTo('App\Models\WilProvinsi', 'province_id', 'id');
    }

    public function Kabupaten()
    {
        return $this->belongsTo('App\Models\WilKabupaten', 'regency_id', 'id');
    }

    public function Kecamatan()
    {
        return $this->belongsTo('App\Models\WilKecamatan', 'district_id', 'id');
    }

    public function Desa()
    {
        return $this->belongsTo('App\Models\WilDesa', 'village_id', 'id');
    }
}
