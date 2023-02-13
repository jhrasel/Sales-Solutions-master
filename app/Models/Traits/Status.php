<?php


namespace App\Models\Traits;


class Status
{
    const STATUS_BLOCKED = 'blocked';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static function listStatus(): array
    {
        return [
            self::STATUS_ACTIVE => 'active',
            self::STATUS_BLOCKED => 'blocked',
            self::STATUS_INACTIVE  => 'inactive',
        ];

    }
}
