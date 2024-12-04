<?php

namespace App\Order;

enum OrderStatus
{
    case PENDING;
    case APPROVE;
    case CANCEL;
}
