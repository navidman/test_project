<?php

namespace Modules\PartnerCompanies\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Entities\Users;

class PartnerCompanies extends Model
{
    use HasFactory;

    protected $table = 'partner_companies';
    protected $fillable = [
        'from_id',
        'to_id',
        'revision',
        'active',
        'status',
    ];
    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\PartnerCompanies\Database\factories\PartnerCompaniesFactory::new();
    }
}
