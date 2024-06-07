<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Converstion;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SendMessage extends Component
{

    public $selectConversation, $recieverInstance, $body, $attachement,$createdMessage;
    protected $listeners = ['UpdateSendMessage','dispatchMessageSend'];

    public function UpdateSendMessage(Converstion $converstion, User $reciever)
    {
        // dd($converstion,$reciever);
        $this->selectConversation = $converstion;
        $this->recieverInstance = $reciever;

    }

    public function SendMessage()
    {
        // dd($this->body);
        if ($this->body == null) {
            return null;
        }
        $this->createdMessage = Message::create([
            'conversation_id' => $this->selectConversation->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $this->recieverInstance->id,
            'body' => $this->body,
        ]);
        $this->selectConversation->last_time_message = $this->createdMessage->created_at;
        $this->selectConversation->save();
        $this->dispatch('pushMessage',$this->createdMessage->id)->to('chat.chatbox');
        $this->dispatch('refresh')->to('chat.chat-list');
        $this->reset('body');
        $this->dispatch('message-sent');
        $this->dispatch('dispatchMessageSend')->self();

    }

    public function dispatchMessageSend()
    {
        broadcast(new MessageSent(Auth()->user(),$this->createdMessage,$this->selectConversation,$this->recieverInstance));

    }

    public function render()
    {
        return view('livewire.chat.send-message');
    }
}
