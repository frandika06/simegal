<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterKategoriKelompok extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;
    public $incrementing = false;
    protected $table = "master_kategori_kelompok";
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

    public function RelMasterJenisPelayanan()
    {
        return $this->belongsTo('App\Models\MasterJenisPelayanan', 'uuid_jp', 'uuid')->withTrashed();
    }

    public function RelMasterKelompokUttp()
    {
        return $this->belongsTo('App\Models\MasterKelompokUttp', 'uuid_kelompok_uutp', 'uuid')->withTrashed();
    }
}
