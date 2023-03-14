<?php

namespace Domain\Order\Enums;

enum OrderStatuses: string {
    case New = 'new';
    case Pending = 'pending';
    case Pay = 'pay';
    case Canceled = 'canceled';
    case Success = 'success';
}
