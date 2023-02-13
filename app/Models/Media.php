<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = ["name","parent_id","type"];

    public function getNameAttribute($value): ?string
    {
        return $value ? asset($value) : null;
    }
}
