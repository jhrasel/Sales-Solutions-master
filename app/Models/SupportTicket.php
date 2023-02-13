<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupportTicket extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = [];

    const OPENED = 'opened';
    const PROCESSING = 'processing';
    const SOLVED = 'solved';
    const CLOSED = 'closed';

    public static function listStatus(): array
    {
        return [
            self::OPENED => 'opened',
            self::PROCESSING => 'processing',
            self::SOLVED  => 'solved',
            self::CLOSED => 'closed'
        ];

    }

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->toFormattedDateString();
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function attachment(): BelongsTo
    {
        return $this->belongsTo(Attachment::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TicketComment::class, 'ticket_id')->orderByDesc('created_at');
    }


}
