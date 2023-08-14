<?php

namespace Modules\Payments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Discount\Entities\Discount;
use Modules\Users\Entities\Users;

class Payments extends Model
{
    use HasFactory;

    /* Relationship to User */
    public function user_tbl()
    {
        return $this->belongsTo(Users::class, 'uid', 'id')->select(array('id', 'full_name'));
    }

    /* Relationship to Discount */
    public function discount_tbl()
    {
        return $this->belongsTo(Discount::class, 'discount_id', 'id')->select(array('id', 'title'));
    }

    protected $table = 'payments';
    protected $fillable = [
        'uid',
        'title',
        'product_type',
        'product_id',
        'discount_amount',
        'amount',
        'payment_amount',
        'discount_id',
        'order_description',
        'order_meta',
        'gateway',
        'currency',
        'transaction_id',
        'transaction_result',
        'viewed',
        'status',
    ];

    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\Payments\Database\factories\PaymentsFactory::new();
    }
}
