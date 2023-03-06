<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    const PENDING = 'pending';
    const FOLLOWUP = 'follow_up';
    const CANCELLED = 'cancelled';
    const CONFIRMED = 'confirmed';
    const RETURNED = 'returned';
    const DELIVERED = 'delivered';

    protected $guarded = [];

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

    public function note(): HasMany
    {
        return $this->hasMany(OrderNote::class);
    }
}
