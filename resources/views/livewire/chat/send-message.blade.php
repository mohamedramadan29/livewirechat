<div>
    @if($selectConversation)
        <form action="" wire:submit.prevent="SendMessage" enctype="multipart/form-data">
            <div class="chatbox_footer">
                <div class="custom_form_group">
                    <input wire:model="body" type="text" name="body" id="sendMessage" class="control" placeholder="Write message">
                    {{--                    <input wire:model="attachement" type="file" id="image" class="control" placeholder="Write message">--}}
                    <button type="submit" class="submit">Send</button>
                </div>
            </div>
        </form>
    @endif

</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

