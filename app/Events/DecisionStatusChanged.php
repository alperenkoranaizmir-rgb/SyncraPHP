<?php

namespace App\Events;

use App\Models\Decision;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\BroadcastOn;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class DecisionStatusChanged implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public Decision $decision;
    public array $payload;

    public function __construct(Decision $decision, array $payload = [])
    {
        $this->decision = $decision;
        $this->payload = $payload;
    }

    public function broadcastOn()
    {
        return new Channel('project.'.$this->decision->project_id);
    }

    public function broadcastWith()
    {
        return array_merge([
            'decision_id' => $this->decision->id,
            'status' => $this->decision->status,
        ], $this->payload);
    }
}
