<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PortalFAQ extends Model
{
    use HasFactory, SoftDeletes;
    public $incrementing = false;
    protected $table = "portal_faq";
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

    public function Publisher()
    {
        return $this->belongsTo('App\Models\Pegawai', 'uuid_created', 'uuid')->withTrashed();
    }
}
