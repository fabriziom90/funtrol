<?php

namespace App\Enums;

enum MovementType: string
{
    case PRODUCTION = 'production';
    case STOCK_IN = 'stock_in';
    case STOCK_OUT = 'stock_out';
    case ORDER = 'order';
    case SUPPLIER_RETURN = 'supplier_return';
    case CUSTOMER_RETURN = 'customer_return';
    case ADJUSTMENT = 'adjustment';
    case INVENTORY_COUNT = 'inventory_count';
}
