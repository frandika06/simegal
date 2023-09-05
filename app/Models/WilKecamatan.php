<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilKecamatan extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $timestamps = false;
    protected $table = "districts";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function Kabupaten()
    {
        return $this->belongsTo('App\Models\WilKabupaten' , 'regency_id' , 'id');
    }

    public function Desa()
    {
        return $this->hasMany('App\Models\WilDesa' , 'id' , 'district_id');
    }
}
