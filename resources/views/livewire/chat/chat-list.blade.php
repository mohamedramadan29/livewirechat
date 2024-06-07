<div>
    {{-- Care about people's approval and you will be their prisoner. --}}

    <div class="chatlist_header">
        <div class="title">
            Chat
        </div>
        <div class="img_container">
            <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{auth()->user()->name}}" alt="">
        </div>
    </div>
    <div class="chatlist_body">

        <!--------------- one items ---------------------->
        @if(count($conversations) > 0)
            @foreach($conversations as $conversation)
                <div class="chatlist_item" wire:key="{{$conversation->id}}"
                     wire:click="$dispatch('ChatUserSelected', { conversationId: {{ $conversation->id }}, receiverId: '{{ $this->getuserinsatance($conversation, 'id') }}' })">
                    <!-- محتوى العنصر هنا -->
                    <div class="chatlist_img_container">
                        <img
                            src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{$this->getuserinsatance($conversation,$name = 'id')}}"
                            alt="">
                    </div>

                    <div class="chatlist_info">
                        <div class="top_row">
                            <div class="list_username"> {{$this->getuserinsatance($conversation,$name = 'name')}}
                                || {{$this->getuserinsatance($conversation,$name = 'id')}}  </div>
                            <span
                                class="date"> {{$conversation->messages->last()->created_at->shortAbsoluteDiffForHumans()}} </span>
                        </div>
                        <div class="bottom_row">
                            <div class="message_body text-truncate">
                                {{$conversation->messages->last()->body}}
                            </div>
                            <div class="unread_count"> 2</div>
                        </div>
                    </div>
                </div>

            @endforeach
        @else
            No Conversations
        @endif


    </div>
</div>
