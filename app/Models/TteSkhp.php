<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TteSkhp extends Model
{
    use HasFactory, SoftDeletes;
    public $incrementing = false;
    protected $table = "tte_skhp";
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

    public function RelPegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'uuid_pejabat', 'uuid')->withTrashed();
    }
}
