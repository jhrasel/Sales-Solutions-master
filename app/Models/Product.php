<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function main_image(): BelongsTo
    {
        return $this->belongsTo(Media::class,'id','parent_id')->where('type','product_main_image');
    }

    public function other_images(): HasMany
    {
        return $this->hasMany(Media::class, 'parent_id')->where('type','product_other_image');
    }



}
