<?php

namespace App\Events;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class AlertEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public array $role,
        public int $user_id,
        public string $time,
        public string $alert,
        public string $color,
        public string $icon,
        public string $link,
    ) {
        if ($user_id == 0) {
            $users = User::whereIn('role', $role)->get();
            foreach ($users as $user) {
                $data = [
                    'user_id' => $user_id == 0 ? $user->id : $user_id,
                    'message' => $alert,
                    'color' => $color,
                    'icon' => $icon,
                    'link' => $link,
                ];
                Notification::create($data);
            }
        } else {
            $data = [
                'user_id' => $user_id,
                'message' => $alert,
                'color' => $color,
                'icon' => $icon,
                'link' => $link,
            ];
            Notification::create($data);
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('alert-channel'),
        ];
    }
}
