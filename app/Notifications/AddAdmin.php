<?php

namespace App\Notifications;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class AddAdmin extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Admin $admin) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'admin_id'      => $this->admin->id,
            'admin_name'    => $this->admin->name,
            'title'         => 'New Admin Added',
            'message'       => "Admin {$this->admin->name} has been added to the system.",
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'admin_id'      => $this->admin->id,
            'admin_name'    => $this->admin->name,
            'title'         => 'New Admin Added',
            'message'       => "Admin {$this->admin->name} has been added to the system.",
            'created_at'    => Carbon::parse($this->admin->created_at)->diffForHumans(),
            'is_read'       => false,
        ]);
    }

    /**
     * Get the type of the notification being broadcast.
     */
    public function broadcastType(): string
    {
        return 'admin.added';
    }

    /**
     * Get the type of the notification being broadcast.
     */
    public function databaseType(): string
    {
        return 'admin.added';
    }
}
