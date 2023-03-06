<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 */

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const PENDING = 'pending';
    public const FOLLOWUP = 'follow_up';
    public const CANCELLED = 'cancelled';
    public const CONFIRMED = 'confirmed';
    public const RETURNED = 'returned';
    public const DELIVERED = 'delivered';



    public function getOrderStatusAttribute($value)
    {
        return $value;
    }

    public function order_details(): HasMany
    {
        return $this->hasMany(OrderDetails::class)->with('product');
    }

    public function pricing(): HasOne
    {
        return $this->hasOne(OrderPricing::class);
    }

    public function courier(): HasOne
    {
        return $this->hasOne(OrderCourier::class);
    }

    public function config(): HasOne
    {
        return $this->hasOne(OrderConfig::class);
    }

}
