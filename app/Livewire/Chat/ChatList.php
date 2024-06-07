<?php

namespace App\Livewire\Chat;

use App\Models\Converstion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatList extends Component
{

    public $conversations;
    public $auth_id;
    public $receiverInsatnce;

    public $name;

    public $selectedConversation;
    public $selectedconversation;

    protected $listeners = ['ChatUserSelected','refresh'=>'$refresh','resetComponent'];

    public function resetComponent()
    {
        $this->selectedconversation = null;
        $this->receiverInsatnce = null;
    }
    public function refresh()
    {

    }
    public function ChatUserSelected($conversationId, $receiverId)
    {
        //  dd($conversationId,$receiverId);
        $this->selectedConversation = Converstion::find($conversationId);
        $this->receiverInstance = User::find($receiverId);
        $this->dispatch('loadconversation',$this->selectedConversation,$this->receiverInstance)->to('chat.chatbox');
        $this->dispatch('UpdateSendMessage',$this->selectedConversation,$this->receiverInstance)->to('chat.send-message');
    }

    public function getuserinsatance(Converstion $conversation, $request)
    {
        if ($conversation->sender_id == Auth::id()) {
            $this->receiverInsatnce = User::where('id', $conversation->receiver_id)->first();
        } else {
            $this->receiverInsatnce = User::where('id', $conversation->sender_id)->first();
        }
        if (isset($request)) {

            return $this->receiverInsatnce->$request;
        }
    }

    public function mount()
    {
        $this->auth_id = Auth::id();
        $this->conversations = Converstion::where('sender_id', Auth::id())
            ->orwhere('receiver_id', Auth::id())
            ->orderby('last_time_message', 'desc')
            ->get();
        // dd($this->conversations);
    }


    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}
