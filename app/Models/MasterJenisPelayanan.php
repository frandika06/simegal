<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterJenisPelayanan extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;
    public $incrementing = false;
    protected $table = "master_jenis_pelayanan";
    protected $primaryKey = "uuid";
    protected $keyType = 'string';
    protected $cascadeDeletes = ['RelMasterKelompokUttp', 'RelMasterKategoriKelompok'];
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

    public function RelMasterKelompokUttp()
    {
        return $this->hasMany('App\Models\MasterKelompokUttp', 'uuid_jp', 'uuid');
    }

    public function RelMasterKategoriKelompok()
    {
        return $this->hasMany('App\Models\MasterKategoriKelompok', 'uuid_jp', 'uuid');
    }
}
