<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory, HasUuid;
    protected $guarded = [];

    public function getPathAttribute($value): ?string
    {
        return $value ? asset($value) : null;
    }

}