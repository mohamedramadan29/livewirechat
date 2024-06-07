<div>

    <div class="chatbox_header">
        <div class="return">
            <i class="bi bi-arrow-left"></i>
        </div>
        @if($recieverInstance)
            <div class="img_container">
                <img
                        src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{$recieverInstance->id}}"
                        alt="">
            </div>
            <div class="name">
                {{ $recieverInstance->name }}
            </div>
        @else
            <div class="name">
                UserName
            </div>
        @endif


        <div class="info">
            <div class="info_item">
                <i class="bi bi-telephone-fill"></i>
            </div>
            <div class="info_item">
                <i class="bi bi-image"></i>
            </div>
            <div class="info_item">
                <i class="bi bi-info-circle-fill"></i>
            </div>
        </div>
    </div>
    <div class="chatbox_body">
        @if($selectConversation)

            @foreach($messages as $message)
                <div
                        class="msg_body {{Auth::id() == $message->sender_id?'msg_body_me':'msg_body_receiver'}}"
                        style="width:80%;max-width:80%;max-width:max-content">
                    {{$message->body}}
                    <div class="msg_body_footer">
                        <div class="date">
                            {{$message->created_at->format('m: i a')}}
                        </div>
                        <div class="read">
                            @php
                                if($message->user->id === auth()->id()){
                                          if($message->red == 0){
                                              echo'<i class="bi bi-check2 status_tick"></i> ';
                                          }
                                          else {
                                              echo'<i class="bi bi-check2-all text-primary"></i> ';
                                          }
                                }
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach
            <script>
                $(".chatbox_body").on('scroll', function () {
                    // alert('aahsd');
                    var top = $('.chatbox_body').scrollTop();
                    //   alert('aasd');
                    if (top == 0) {

                        window.livewire.dispatch('loadmore');
                    }

                });
            </script>


            <script>
                // window.addEventListener('updatedHeight', event => {
                //
                //     let old = event.detail.height;
                //     let newHeight = $('.chatbox_body')[0].scrollHeight;
                //
                //     let height = $('.chatbox_body').scrollTop(newHeight - old);
                //
                //
                //     window.livewire.dispatch('updateHeight', {
                //         height: height,
                //     });
                //
                //
                // });
            </script>
        @else
            No Conversation Selected
        @endif


    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        window.addEventListener('message-sent', event => {
            document.getElementById('sendMessage').value = '';
        });
    </script>

    <script>
        window.addEventListener('chatSelected', event => {

            if (window.innerWidth < 768) {

                $('.chat_list_container').hide();
                $('.chat_box_container').show();

            }

            // $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight);
            // let height = $('.chatbox_body')[0].scrollHeight;
            // //alert(height);
            // window.livewire.dispatch('updateHeight', {
            //
            //     height: height,
            //
            //
            // });
        });


        $(window).resize(function () {

            if (window.innerWidth > 768) {
                $('.chat_list_container').show();
                $('.chat_box_container').show();

            }

        });


        $(document).on('click', '.return', function () {

            $('.chat_list_container').show();
            $('.chat_box_container').hide();


        });
    </script>

    <script>
        $(document).on('scroll', '#chatBody', function () {

            var top = $('.chatbox_body').scrollTop();
            if (top == 0) {

                window.livewire.dispatch('loadmore');
            }

        });

    </script>

    <script>
        window.addEventListener('rowChatToBottoms', event => {

            $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight);

        });
    </script>

    <script>
        $(document).on('click', '.return', function () {


            window.livewire.emit('resetComponent');

        });
    </script>
</div>
