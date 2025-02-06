<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PREPARING = 'preparing';
    case COMPLETED = 'completed';

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'text-red-800',
            self::PREPARING => 'text-green-800 ',
            self::COMPLETED => '',
        };
    }
}

