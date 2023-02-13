<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Page extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'user_id' => 'integer',
        'shop_id' => 'integer',
        'theme' => 'integer',
        'status' => 'integer',
        'product_id' => 'integer'
    ];

    public function theme(): HasOne
    {
        return $this->hasOne(Theme::class, 'id', 'theme');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
