<?php
namespace App\Livewire\Chat;
use App\Models\Converstion;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateChat extends Component
{
    public $users;
    public $message = 'hello how are You';

    public function checkconversation($receiverId)
    {
        $checkConversation = Converstion::where('sender_id', Auth::id())->where('receiver_id', $receiverId)
            ->Orwhere('sender_id', $receiverId)->where('receiver_id', Auth::id())
            ->get();
        if (count($checkConversation) == 0) {
            //  dd('No Conversation');
            // //// Create Chat
            $createConversation = Converstion::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $receiverId,
            ]);
            // Create Message
            $createMessage = Message::create([
                'conversation_id'=>$createConversation->id,
                'sender_id' => Auth::id(),
                'receiver_id' => $receiverId,
                'body'=>$this->message,
            ]);
            $createConversation->last_time_message = $createMessage->created_at;
            $createConversation->save();
            dd('saved');
        } elseif (count($checkConversation)  > 0) {
            dd('conversation sataty');
        }
    }

    public function render()
    {
        $this->users = User::WhereNot('id', Auth::id())->get();
        return view('livewire.chat.create-chat');
    }
}
