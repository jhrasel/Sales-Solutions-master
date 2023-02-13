<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantCourier extends Model
{
    use HasFactory;
    protected $guarded =[];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STEADFAST = 'steadfast';
    const REDX = 'redx';
    const PATHAO = 'pathao';
    const PAPERFLY = 'paperfly';
    const ECOURIER = 'ecourier';

}
