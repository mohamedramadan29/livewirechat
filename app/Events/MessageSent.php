<?php

namespace App\Events;

use App\Models\Converstion;
use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use function Laravel\Prompts\error;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $conversation;

    public $message;
    public $reciever;

    public function __construct(User $user, Message $message, Converstion $conversation, User $reciever)
    {
        $this->user = $user;
        $this->message = $message;
        $this->conversation = $conversation;
        $this->reciever = $reciever;
    }

    public function broadcastWith()
    {
        return [
            'user_id' => $this->user->id,
            'message' => $this->message->id,
            'conversation_id' => $this->conversation->id,
            'receiver_id' => $this->reciever->id,
        ];
    }
//    public function broadcastOn(): array
//    {
//        error_log($this->user);
//        error_log($this->reciever);
//        return [
//            new PrivateChannel('chat.'.$this->reciever->id),
//        ];
//    }
    public function broadcastOn()
    {
        error_log($this->user);
        error_log($this->reciever);
        return new PrivateChannel('chat.' . $this->reciever->id);
    }
}
