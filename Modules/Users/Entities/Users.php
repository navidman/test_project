<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\FileLibrary\Entities\FileLibrary;

class Users extends Model
{
    use HasFactory;


    public function avatar()
    {
        return $this->belongsTo(FileLibrary::class, 'avatar', 'id');
    }

    public function avatar_tbl()
    {
        return $this->belongsTo(FileLibrary::class, 'avatar', 'id');
    }

    public function official_newspaper_avatar_tbl()
    {
        return $this->belongsTo(FileLibrary::class, 'official_newspaper', 'id');
    }

    protected $fillable = [
        'full_name',
        'email',
        'company_name_fa',
        'company_name_en',
        'organization_level',
        'economic_code',
        'organization_phone',
        'shaba',
        'province',
        'city',
        'district',
        'phone',
        'website',
        'company_activity',
        'number_of_staff',
        'job_group',
        'biography',
        'gender',
        'avatar',
        'cover_image',
        'official_newspaper',
        'role',
        'parent_id',
        'panel_access',
        'status',
        'password',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function newFactory()
    {
        return \Modules\Users\Database\factories\UsersFactory::new();
    }
}
