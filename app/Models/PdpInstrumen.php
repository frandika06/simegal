<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PdpInstrumen extends Model
{
    use HasFactory, SoftDeletes;
    public $incrementing = false;
    protected $table = "pdp_instrumen";
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

    public function RelPdpPenjadwalan()
    {
        return $this->belongsTo('App\Models\PdpPenjadwalan', 'uuid_penjadwalan', 'uuid')->withTrashed();
    }

    public function RelMasterInstrumenDaftarItemUttp()
    {
        return $this->belongsTo('App\Models\MasterInstrumenDaftarItemUttp', 'uuid_instrumen', 'uuid')->withTrashed();
    }
}
