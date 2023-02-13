<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable =['title', 'description', 'shop_id', 'user_id' ];

    public function slider_image()
    {
        return $this->belongsTo(Media::class,'id','parent_id')->where('type','merchant_slider');
    }
}
