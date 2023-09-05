<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilProvinsi extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $timestamps = false;
    protected $table = "provinces";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function Kabupaten()
    {
        return $this->hasMany('App\Models\WilKabupaten' , 'id' , 'province_id');
    }
}
