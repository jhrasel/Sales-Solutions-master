<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $order_status
 * @property string $order_no
 * @property string $shop_id
 * @property string $customer_name
 * @property string $phone
 * @property string $address
 * @property string $created_at
 * @property string $updated_at
 * @property array $order_details
 * @property string $delivery_location
 * @property object $pricing
 * @property object $config
 * @property object $courier
 * @property bool $cod
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
