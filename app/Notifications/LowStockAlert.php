<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\InventoryItem;

class LowStockAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public InventoryItem $item)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Low Stock Alert: ' . $this->item->name)
            ->line("Inventory item {$this->item->name} is below minimum stock level.")
            ->line("Current stock: {$this->item->stock_quantity} {$this->item->storage_unit}")
            ->line("Minimum required: {$this->item->min_stock} {$this->item->storage_unit}")
            ->action('View Item', route('inventory.show', $this->item));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'item_id' => $this->item->id,
            'message' => "Low stock alert for {$this->item->name}",
            'current_stock' => $this->item->stock_quantity,
            'min_stock' => $this->item->min_stock,
            'url' => route('inventory.show', $this->item)
        ];
    }
}
