<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Converstion;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class Chatbox extends Component
{
    public $selectConversation;
    public $recieverInstance;
    public $message_count;
    public $messages;
    public $paginatevar = 10;

    public function getListeners()
    {
        $auth_id = Auth::id();
        return [
            "echo-private:chat.{$auth_id},MessageSent" => 'MessageReceived',
            'loadconversation', 'pushMessage', 'loadmore'
        ];
    }

    function MessageReceived($event)
    {
        // Refresh chat list
        $this->dispatch('refresh')->to('chat.chat-list');

        $broadcastedMessage = Message::find($event['message']);

       // dd($broadcastedMessage);
        // Check if message exists
        if (!$broadcastedMessage) {
            // Handle the case where the message is not found
            return;
        }

        // Check if any selected conversation is set
        if ($this->selectConversation) {
            // Check if Auth/current selected conversation is same as broadcasted selected conversation
            if ((int) $this->selectConversation->id === (int) $event['conversation_id']) {
                // Mark message as read
                $broadcastedMessage->red = 1; // Assumes you have a 'read' field in your messages table
               $broadcastedMessage->save();
                $this->pushMessage($broadcastedMessage->id);
                // Emit an event to the frontend
                $this->dispatch('broadcastMessageRead')->self();
            }
        }
    }

    public function pushMessage($messageId)
    {
        $newMessage = Message::find($messageId);
        $this->messages->push($newMessage);
        $this->dispatch('rowChatToBottoms');
    }

    public function loadmore()
    {
        dd('top');
    }

    public function loadconversation(Converstion $converstion, User $reciever)
    {
        // dd($converstion,$reciever);
        $this->selectConversation = $converstion;
        $this->recieverInstance = $reciever;
        //dd($this->recieverInstance);
        $this->message_count = Message::where('conversation_id', $this->selectConversation->id)->count();
        $this->messages = Message::where('conversation_id', $this->selectConversation->id)
            ->skip($this->message_count - $this->paginatevar)
            ->take($this->paginatevar)->get();

        $this->dispatch('chatSelected');
    }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }
}
