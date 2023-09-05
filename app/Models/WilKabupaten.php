<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilKabupaten extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $timestamps = false;
    protected $table = "regencies";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function Provinsi()
    {
        return $this->belongsTo('App\Models\WilProvinsi' , 'province_id' , 'id');
    }

    public function Kecamatan()
    {
        return $this->hasMany('App\Models\WilKecamatan' , 'id' , 'regency_id');
    }
}
