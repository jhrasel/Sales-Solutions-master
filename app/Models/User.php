<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ADMIN = 'admin';
    const MERCHANT = 'merchant';
    const CUSTOMER = 'customer';
    const STAFF = 'staff';

    const STATUS_BLOCKED = 'blocked';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['avatar'];


    public static function listStatus(): array
    {
        return [
            self::STATUS_ACTIVE => 'active',
            self::STATUS_BLOCKED => 'blocked',
            self::STATUS_INACTIVE  => 'inactive',
        ];

    }

    public static function normalizePhone($phone): string
    {
        if(Str::startsWith($phone, "+88")) {
            return $phone;
        }
        return '+88'.$phone;
    }

    public static function removeCode($phone): string
    {
        if(Str::startsWith($phone, "+88")) {
            return Str::remove('+88', $phone);
        }
        return $phone;
    }


    /**
     * return password as a hash
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * @param $value
     * @return string
     */
    public function getAvatarAttribute($value): string
    {
        return $value ?: asset('images/profile.png');

    }

    /**
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->toFormattedDateString();
    }

    /**
     * Return The shop that belongs to this User
     *
     */
    public function shop(): HasOne
    {
        return $this->hasOne(Shop::class);
    }

    /**
     * @return HasOne
     */
    public function merchantinfo(): HasOne
    {
        return $this->hasOne(MerchantInfo::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'category_user');
    }

    public function support_ticket(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function customer_info(): HasOne
    {
        return $this->hasOne(CustomerInfo::class);
    }

    public function createApiToken(): string
    {
        $token = Str::random(64);
        $this->api_token = $token;
        $this->save();

        $browser = $this->get_browser(request()->header('User-Agent'));
        $merchant_tokens = MerchantToken::query()->create([
            'token' => $token,
            'user_id' => $this->id,
            'ip' => request()->ip(),
            'browser' => $browser
        ]);
        return $token;
    }

    public function removeApiToken(): string
    {
        $merchant_tokens = MerchantToken::query()->where('user_id', $this->id)->where('token', $this->api_token)->first();
        $merchant_tokens->delete();
        $this->api_token=null;
        $this->save();
        return 'Successfully logged out';
    }

    public function get_browser($value)
    {
        $bname = '';
        if(preg_match('/MSIE/i',$value) && !preg_match('/Opera/i',$value))
        {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }
        elseif(preg_match('/Firefox/i',$value))
        {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }
        elseif(preg_match('/Chrome/i',$value))
        {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }
        elseif(preg_match('/Safari/i',$value))
        {
            $bname = 'Apple Safari';
            $ub = "Safari";
        }
        elseif(preg_match('/Opera/i',$value))
        {
            $bname = 'Opera';
            $ub = "Opera";
        }
        elseif(preg_match('/Netscape/i',$value))
        {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        return $bname;
    }
}
