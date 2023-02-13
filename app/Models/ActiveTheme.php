<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActiveTheme extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }
}
