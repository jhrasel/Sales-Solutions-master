<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeEdit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getLogoAttribute($value): string
    {
        return asset($value);
    }

    public function update(array $attributes = [], array $options = []): bool
    {
        foreach ($attributes as $key => $value) {
            if (!is_null($value)) $this->{$key} = $value;
        }
        return $this->save();
    }

    public function theme()
    {
       return $this->hasMany(Theme::class)->where();
    }
}
