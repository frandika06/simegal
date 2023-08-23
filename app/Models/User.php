<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public $incrementing = false;
    protected $primaryKey = "uuid";
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "uuid",
        "uuid_profile",
        "username",
        "password",
        "remember_token",
        "role",
        "sub_role",
        "sub_sub_role",
        "status",
        "uuid_created",
        "uuid_updated",
        "uuid_deleted",
        "last_seen",
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        "uuid_created",
        "uuid_updated",
        "uuid_deleted",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function RelPegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'uuid_profile', 'uuid')->withTrashed();
    }

    public function RelPerusahaan()
    {
        return $this->belongsTo('App\Models\Perusahaan', 'uuid_profile', 'uuid')->withTrashed();
    }
}
