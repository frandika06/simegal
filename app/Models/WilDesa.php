<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilDesa extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $timestamps = false;
    protected $table = "villages";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function Kecamatan()
    {
        return $this->belongsTo('App\Models\WilKecamatan' , 'district_id' , 'id');
    }
}
