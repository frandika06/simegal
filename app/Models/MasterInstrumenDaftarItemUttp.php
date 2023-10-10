<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterInstrumenDaftarItemUttp extends Model
{
    use HasFactory, SoftDeletes;
    public $incrementing = false;
    protected $table = "master_instrumen_daftar_item_uttp";
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

    public function RelMasterInstrumenJenisUttp()
    {
        return $this->belongsTo('App\Models\MasterInstrumenJenisUttp', 'uuid_instrumen_jenis_uttp', 'uuid')->withTrashed();
    }
}
