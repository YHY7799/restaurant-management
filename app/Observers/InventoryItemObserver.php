<?php

namespace App\Observers;


use App\Models\InventoryItem;
use App\Notifications\LowStockAlert;

class InventoryItemObserver
{
    public function updating(InventoryItem $item)
    {
        // Check if stock is below minimum threshold
        if ($item->min_stock && 
            $item->stock_quantity < $item->min_stock && 
            !$item->low_stock_alert_sent
        ) {
            $this->sendLowStockAlert($item);
            $item->low_stock_alert_sent = true;
        }
        
        // Reset alert if stock is replenished above threshold
        if ($item->min_stock && 
            $item->stock_quantity >= $item->min_stock && 
            $item->low_stock_alert_sent
        ) {
            $item->low_stock_alert_sent = false;
        }
    }

    protected function sendLowStockAlert(InventoryItem $item)
    {
        // Send to all admin users
        // $admins = User::where('role', 'admin')->get();
        
        // Notification::send($admins, new LowStockAlert($item));
    }
}