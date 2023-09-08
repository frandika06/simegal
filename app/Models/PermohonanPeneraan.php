<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermohonanPeneraan extends Model
{
    use HasFactory, SoftDeletes;
    public $incrementing = false;
    protected $table = "permohonan_peneraan";
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
        return $this->belongsTo('App\Models\Perusahaan', 'uuid_perusahaan', 'uuid')->withTrashed();
    }

    public function RelAlamatPerusahaan()
    {
        return $this->belongsTo('App\Models\AlamatPerusahaan', 'uuid_alamat', 'uuid')->withTrashed();
    }
}
