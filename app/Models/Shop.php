<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shop extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function shop_logo(): BelongsTo
    {
        return $this->belongsTo(Media::class,'id','parent_id')->where('type','shop_logo');
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
