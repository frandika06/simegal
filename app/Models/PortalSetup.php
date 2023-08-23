<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortalSetup extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "portal_setup";
    protected $primaryKey = "uuid";
    protected $keyType = 'string';
    protected $guarded = [];
    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at",
    ];
}
