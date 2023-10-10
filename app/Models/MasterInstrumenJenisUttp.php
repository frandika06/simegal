<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterInstrumenJenisUttp extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;
    public $incrementing = false;
    protected $table = "master_instrumen_jenis_uttp";
    protected $primaryKey = "uuid";
    protected $keyType = 'string';
    protected $cascadeDeletes = ['RelMasterInstrumenDaftarJenisUttp'];
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

    public function RelMasterInstrumenDaftarJenisUttp()
    {
        return $this->hasMany('App\Models\MasterInstrumenDaftarJenisUttp', 'uuid_instrumen_jenis_uttp', 'uuid');
    }
}
