<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function website_shop_logo()
    {
        return $this->belongsTo(Media::class,'id','parent_id')->where('type','website_shop_logo');
    }
}
