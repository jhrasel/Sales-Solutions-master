<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Theme extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class,'id','parent_id')->where('type', 'template');
    }

}
