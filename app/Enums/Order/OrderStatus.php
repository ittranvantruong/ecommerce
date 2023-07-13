<?php

namespace App\Enums\Order;

use App\Support\Enum;

enum OrderStatus: int
{
    use Enum;

    case Processing = 1;
    case Processed = 2;
    case Completed = 3;
    case Cancelled = 4;

    public function badge(){
        return match($this) {
            OrderStatus::Processing => 'bg-yellow-lt',
            OrderStatus::Processed => 'bg-lime-lt',
            OrderStatus::Completed => 'bg-green-lt',
            OrderStatus::Cancelled => 'bg-red-lt',
        };
    }
}
