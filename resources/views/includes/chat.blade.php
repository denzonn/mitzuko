@if (Auth::check())
    @if (Auth::user()->roles == 'USER')
        <div class="content">
            <a href="#" class="chat-box">
                <i class="fa-sharp fa-solid fa-comments"> Chat</i>
            </a>
        </div>

        <div class="chat">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row px-3 align-items-center">
                        <h3 class="panel-title">Chat <span style="font-size: 15px">(10)</span></h3>
                        <div class="close">
                            <a href="#"><i class="fa-sharp fa-solid fa-circle-chevron-down"></i></a>
                        </div>
                    </div>
                </div>
                <div class="panel-body mb-2 p-2 panel-user">
                    <ul class="list-unstyled" id="chats" style="height: 540px">
                        @php
                            // Ambil chat berdasarkan message_codenya masing-masing
                            $message_code = Auth::user()->message_code;
                            $chats = App\Models\Chat::where('message_code', $message_code)->get();
                        @endphp
                        @forelse ($chats as $chat)
                            @if ($chat->users_id == Auth::user()->id)
                                <li id="chats" class="me">
                                    <span style="font-size: 16px">{{ $chat->message }}</span>
                                    <span style="font-size: 8px">{{ $chat->created_at->format('H:i') }}</span>
                                </li>
                            @else
                                <li id="chats" class="admin">
                                    <span style="font-size: 16px">{{ $chat->message }}</span>
                                    <span style="font-size: 8px">{{ $chat->created_at->format('H:i') }}</span>
                                </li>
                            @endif
                        @empty
                            Kosong
                        @endforelse
                    </ul>
                </div>

                <div class="panel-footer">
                    <form action="/api/chat" method="post" enctype="multipart/form-data" id="formUser">
                        @csrf
                        <div class="input-group">
                            <input type="hidden" name="users_id_roles"
                                value="{{ Auth::user()->id }}, {{ Auth::user()->roles }}">
                            <input type="text" class="form-control" placeholder="Type a message..." name="message">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa-sharp fa-solid fa-paper-plane"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        {{-- Message --}}
        <div class="content">
            <a href="#" class="chat-box">
                <i class="fa-sharp fa-solid fa-comments"> Chat</i>
            </a>
        </div>

        <div class="chat">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row px-3 align-items-center">
                        <h3 class="panel-title">Admin Chat <span style="font-size: 15px">(10)</span></h3>
                        <div class="close">
                            <a href="#"><i class="fa-sharp fa-solid fa-circle-chevron-down"></i></a>
                        </div>
                    </div>
                </div>
                <div class="panel-body p-2 ">
                    <div class="row">
                        <div class="col-8">
                            {{-- Tampilan awal --}}
                            <div class="empty-user text-center" style="line-height: 500px">
                                <img src="/images/chat.png" alt="" style="width: 50px; height: auto">
                                <span>Pilih User</span>
                            </div>
                            <div class="filled-user pr-3" style="height:530px; overflow-y: scroll; visibility: hidden">

                            </div>
                        </div>
                        <div class="col-4">
                            {{-- Sidebar Chat --}}
                            <ul class="list-unstyled" id="user-chat-list" style="height: 530px; overflow-y: scroll">
                                @php
                                    // Pisahkan chat berdasarkan usernya masing-masing
                                    $user = App\Models\Chat::select('message_code', 'users_id')
                                        ->distinct()
                                        ->get();
                                @endphp
                                @forelse ($user as $chat)
                                    {{-- Tampilakan dlu semua user --}}
                                    <div class="card mb-2">
                                        <a href="#"
                                            onclick="loadChat('{{ $chat->message_code }}', {{ $chat->users_id }})"
                                            style="text-decoration: none; color: #00022e; font-weight: 500">
                                            <div class="card-body">
                                                <img src="{{ Storage::url($chat->user->photo ?? '../images/user.png') }}"
                                                    style="width: 30px; height: auto">
                                                <span class="ml-1"
                                                    style="font-size: 14px">{{ $chat->user->name }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    Kosong
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <form action="/api/chat" method="post" enctype="multipart/form-data" id="formAdmin">
                        @csrf
                        <div class="input-group">
                            <input type="hidden" name="users_id_roles"
                                value="{{ Auth::user()->id }}, {{ Auth::user()->roles }}">
                            <input type="text" class="form-control" placeholder="Type a message..." name="message">
                            @foreach ($user as $item)
                                <input type="hidden" name="message_code" value="{{ $item->message_code }}">
                            @endforeach
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa-sharp fa-solid fa-paper-plane"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@else
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
    integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $('input[name="message"]').val('');

    $(document).ready(function() {

        var chats = $('#chats');

        // Menangkap event submit pada form chat
        $('#formUser').on('submit', function(event) {
            // Mencegah halaman untuk reload
            event.preventDefault();

            // Mengirim data form chat ke server menggunakan AJAX
            $.ajax({
                url: '/api/chat',
                method: 'POST',
                data: $('form').serialize(),
                success: function(response) {
                    // // Jika pengiriman chat berhasil, menambahkan chat ke daftar chat
                    var chat = response.data;
                    // Tambahkan waktu
                    chat.created_at = new Date(chat.created_at);
                    // Tambahkan chat ke daftar chat
                    var message =
                        '<li id="chats" class="me"><span style="font-size: 16px">' + chat
                        .message + '</span> <span style="font-size: 8px">' + chat.created_at
                        .getHours() + ':' + chat.created_at.getMinutes() + '</span></li>';
                    $('#chats').append(message);

                    // Gulung halaman ke bawah setiap kali ada pesan baru
                    chats.scrollTop = chats.scrollHeight;

                    $('input[name="message"]').val('');
                },
                error: function(response) {
                    // Jika pengiriman chat gagal, menampilkan pesan error
                    alert(response.responseJSON.errors.message[0]);
                }
            });

            // Menutup chat box
            $('.close').on('click', function(event) {
                event.preventDefault();
                $('.chat').hide();
            });
        });
    });
</script>

<script>
    $('input[name="message"]').val('');

    $(document).ready(function() {
        // Menangkap event submit pada form chat
        $('#formAdmin').on('submit', function(event) {

            // Mencegah halaman untuk reload
            event.preventDefault();

            // Mengirim data form chat ke server menggunakan AJAX
            $.ajax({
                url: '/api/chat',
                method: 'POST',
                data: $('form').serialize(),
                success: function(response) {
                    var chats = response.data;

                    var filledUser = $('.filled-user');

                    var message = $('<span></span>').text(chats.message).css('font-size',
                            '16px')
                        .css('background-color', '#e6e6e6').css('border-radius', '2px').css(
                            'padding', '2px 5px 2px 5px');
                    var timestamp = $('<span></span>').text(new Date(chats.created_at)
                        .toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit'
                        })).css('font-size', '8px');
                    var chatRow = $('<div></div>').append(message).append(' ').append(
                            timestamp)
                        .css(
                            'margin-bottom', '8px');

                    message.css('background-color', '#6495ed')
                        .css('text-align', 'right')
                        .css('float', 'right')
                        .css('margin-bottom', '8px')
                        .css('margin-left', '5px');
                    timestamp.css('float', 'right');
                    chatRow.css('clear', 'both').css('margin-bottom', '35px');

                    filledUser.append(chatRow);

                    $('input[name="message"]').val('');
                },
                error: function(response) {
                    // Jika pengiriman chat gagal, menampilkan pesan error
                    alert(response.responseJSON.errors.message[0]);
                }
            });

            // Menutup chat box
            $('.close').on('click', function(event) {
                event.preventDefault();
                $('.chat').hide();
            });
        });
    });
</script>

<script>
    const chatBox = document.querySelector('.chat-box');
    const chat = document.querySelector('.chat');
    const close = document.querySelector('.close');

    chatBox.addEventListener('click', function(e) {
        e.preventDefault();
        chat.classList.toggle('visible');
    });

    close.addEventListener('click', function(e) {
        e.preventDefault();
        chat.classList.remove('visible');
    });

    // Ambil element terakhir pada list chat
    const lastChat = document.querySelector("#chats li:last-child");

    // Scroll ke element terakhir
    lastChat.scrollIntoView();
</script>

<script>
    function scrollToBottom() {
        var chat = document.querySelector('.filled-user');
        chat.scrollTop = chat.scrollHeight;
    }

    function loadChat(message_code, users_id) {

        // console.log(message_code);
        $('title').text('Chat - User ' + users_id);

        // Tampilkan chat yang terkait dengan message_code
        $.ajax({
            url: '/api/chat/' + message_code,
            type: 'GET',
            success: function(data) {
                var chats = data.chats;
                var filledUser = $('.filled-user');

                filledUser.css('visibility', 'visible');

                // Bersihkan chat sebelumnya
                filledUser.empty();

                // Tampilkan chat baru
                $.each(chats, function(index, chat) {
                    var message = $('<span></span>').text(chat.message).css('font-size', '16px')
                        .css('background-color', '#e6e6e6').css('border-radius', '2px').css(
                            'padding', '2px 5px 2px 5px');
                    var timestamp = $('<span></span>').text(new Date(chat.created_at)
                        .toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit'
                        })).css('font-size', '8px');
                    var chatRow = $('<div></div>').append(message).append(' ').append(timestamp)
                        .css(
                            'margin-bottom', '8px');


                    // Tambahkan background color jika users_id berbeda
                    if (chat.users_id != users_id) {
                        message.css('background-color', '#6495ed')
                            .css('text-align', 'right')
                            .css('float', 'right')
                            .css('margin-bottom', '8px')
                            .css('margin-left', '5px');
                        timestamp.css('float', 'right');
                        chatRow.css('clear', 'both').css('margin-bottom', '35px');
                    }

                    filledUser.append(chatRow);
                });

                // Scroll ke bawah
                scrollToBottom();

                // Tampilkan class filled-user
                $('.empty-user').hide();
                filledUser.show();
            }
        });
    }
</script>
