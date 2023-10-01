<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perusahaan extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;
    public $incrementing = false;
    protected $table = "perusahaan";
    protected $primaryKey = "uuid";
    protected $keyType = 'string';
    protected $cascadeDeletes = ['RelAlamatPerusahaan', 'RelPermohonanPeneraan'];
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

    public function RelUser()
    {
        return $this->belongsTo('App\Models\User', 'uuid', 'uuid_profile')->withTrashed();
    }

    public function RelAlamatPerusahaan()
    {
        return $this->hasMany('App\Models\AlamatPerusahaan', 'uuid_perusahaan', 'uuid');
    }

    public function RelPermohonanPeneraan()
    {
        return $this->hasMany('App\Models\PermohonanPeneraan', 'uuid_perusahaan', 'uuid');
    }
}
