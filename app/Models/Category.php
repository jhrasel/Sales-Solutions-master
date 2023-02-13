<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category_image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'id', 'parent_id')->where('type', 'category');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function subcategory(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
