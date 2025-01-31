<?php

namespace App\Helpers;

class InventoryHelper
{
    public static function convertToStorageUnit($quantity, $conversionFactor)
    {
        return $quantity / $conversionFactor;
    }

    public static function convertToUsageUnit($quantity, $conversionFactor)
    {
        return $quantity * $conversionFactor;
    }

    public static function formatQuantity($quantity, $unit)
    {
        return number_format($quantity, 2).' '.$unit;
    }
}