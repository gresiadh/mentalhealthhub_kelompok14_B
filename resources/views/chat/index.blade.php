@extends('layouts.app')

@php
    $user = Auth::user();
    $name = $user->first_name;
    if ($reciever != null) {
        # code...
        $sender = DB::table('users')->where('id', $reciever)->first();
    }
@endphp

@section('content')
    <style>
        .chat-tile {
            background: rgb(255, 255, 255);
            cursor: pointer;
        }

        .chat-tile:hover {
            background: rgb(223, 223, 223) !important;
        }


        .chat-container {
            display: flex;
            align-items: center;
            position: relative;
        }

        .file-upload-label {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            background: #f1f1f1;
            border-radius: 50%;
        }

        .upload-icon {
            width: 20px;
            height: 20px;
            color: #007bff;
        }

        .chat-input {
            border: 1px solid rgb(219, 219, 219);
            outline: none;
            height: 100%;
            padding: 0px 10px;
            width: 80%;
            border-radius: 10px;
            font-size: 14px;
        }

        .btn-send {
            background-color: #007bff;
            color: white;
            border: none;
            outline: none;
            padding: 5px 15px;
            border-radius: 10px;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-send:hover {
            background-color: #0056b3;
        }

        .image-preview {
            position: absolute;
            top: -120px;
            left: 10%;
            width: 100px;
            height: 100px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 10px;
            display: none;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .chat-box {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-height: 100%;
            overflow-y: auto;
        }

        .chat-message {
            max-width: 70%;
            padding: 10px;
            border-radius: 10px;
            font-size: 14px;
            line-height: 1.4;
            word-wrap: break-word;
        }

        .chat-message.sent {
            align-self: flex-end;
            background-color: #007bff;
            color: white;
        }

        .chat-message.received {
            align-self: flex-start;
            background-color: #e9ecef;
            color: black;
        }

        .chat-message img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 5px;
        }
    </style>
    <section class="dashboard d-flex py-5">
        <div class="container mt-4">
            <div class="row mt-5">


                <div class="col-md-4">
                    <div class="card m-2">
                        <div class="card-header">{{ __('Counsellor') }}</div>
                        <div class="card-body" style="padding: 0px;">


                            @foreach ($users as $user)
                                <a href="/chat/{{ $user->id }}" class="chat-tile px-4 py-3"
                                    style="display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); color: black;"
                                    attr-id="1">
                                    <div style="width: 40px; height: 40px; margin-right: 10px;"
                                        style="grid-column: span 2 / span 2; border-radius: 100%; overflow: hidden;">
                                        <img src="https://www.gravatar.com/avatar/1c52606…?s=200&d=identicon"
                                            style="width: 100%; height: 100%; border-radius: 100%;" alt="">
                                    </div>

                                    <div
                                        style="grid-column: span 5 / span 5; display: flex; justify-content: space-between; align-items: center; margin-left: 20px;">
                                        <h3 style="font-size: 14px;">{{ $user->first_name }} {{ $user->last_name }}</h3>
                                    </div>

                                </a>
                            @endforeach

                            {{-- <div class="nav flex-column nav-pills mb-3 bg-opacity-50 mx-3 p-3" id="v-pills-tab"
                                role="tablist" aria-orientation="vertical">

                                <button class="btn-inverse active mb-3" id="v-pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-home" type="button" role="tab"
                                    aria-controls="v-pills-home" aria-selected="true">Home</button>
                                <button class="btn-inverse mb-3" id="v-pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-profile" type="button" role="tab"
                                    aria-controls="v-pills-profile" aria-selected="false">Profile</button>
                                <button class="btn-inverse" id="v-pills-settings-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-settings" type="button" role="tab"
                                    aria-controls="v-pills-profile" aria-selected="false">Update Password</button>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <div class="col-md">
                    <div class="card m-2">
                        @if ($reciever != null)
                            <div class="card-header">
                                <div class="d-flex gap-3 jus-content-center align-items-center">
                                    <div style="width: 40px; height: 40px;" style="border-radius: 100%; overflow: hidden;">
                                        <img src="https://www.gravatar.com/avatar/1c52606…?s=200&d=identicon"
                                            style="width: 100%; height: 100%; border-radius: 100%;" alt="">
                                    </div>
                                    <p style="font-weight: 700;">{{ $sender->first_name }}</p>
                                </div>
                            </div>

                            <div class="card-body" style="padding: 0; height: 600px;">
                                <div style="height: 100%; background: rgb(233, 233, 233)">
                                    <div style="height: 90%; overflow-y: auto; background: #f8f9fa; padding: 10px; border-radius: 10px;"
                                        class="chat-box" id="chat-box">
                                        {{-- <!-- Pesan Terkirim (Teks) -->
                                    <div class="chat-message sent">
                                        <p>Ini adalah pesan teks yang dikirim.</p>
                                    </div>

                                    <!-- Pesan Diterima (Teks) -->
                                    <div class="chat-message received">
                                        <p>Halo, terima kasih atas pesan Anda!</p>
                                    </div>

                                    <!-- Pesan Terkirim (Gambar) -->
                                    <div class="chat-message sent">
                                        <img src="https://via.placeholder.com/150" alt="Gambar Terkirim">
                                    </div>

                                    <!-- Pesan Diterima (Gambar) -->
                                    <div class="chat-message received">
                                        <img src="https://via.placeholder.com/150" alt="Gambar Diterima">
                                    </div>

                                    <!-- Pesan Diterima (Teks) -->
                                    <div class="chat-message received">
                                        <p>Halo, terima kasih atas pesan Anda!</p>
                                    </div>


                                    <!-- Pesan Terkirim (Gambar) -->
                                    <div class="chat-message sent">
                                        <img src="https://via.placeholder.com/150" alt="Gambar Terkirim">
                                    </div>

                                    <!-- Pesan Terkirim (Gambar) -->
                                    <div class="chat-message sent">
                                        <img src="https://via.placeholder.com/150" alt="Gambar Terkirim">
                                    </div> --}}

                                    </div>

                                    <div style="height: 8%; background: white; margin: 0px 10px; border-radius: 20px; position: relative;"
                                        class="d-flex chat-container">
                                        <div style="width: 10%;" class="file-upload">
                                            <label for="file-input" class="file-upload-label">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="currentColor" class="upload-icon" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2C12.6 2 13 2.4 13 3V13H16L12 17L8 13H11V3C11 2.4 11.4 2 12 2ZM6 19C6 18.4 5.6 18 5 18C4.4 18 4 18.4 4 19C4 19.6 4.4 20 5 20H19C19.6 20 20 19.6 20 19C20 18.4 19.6 18 19 18C18.4 18 18 18.4 18 19H6Z" />
                                                </svg>
                                            </label>
                                            <input id="file-input" type="file" style="display: none;" accept="image/*">
                                        </div>
                                        <input type="text" class="chat-input" id="message"
                                            placeholder="Tulis pesan di sini...">
                                        <div style="width: 10%;" class="send-button">
                                            <button class="btn-send" onclick="sendMessage()">
                                                Kirim
                                            </button>
                                        </div>
                                        <div id="image-preview" class="image-preview"></div>
                                    </div>

                                </div>
                            </div>
                        @else
                            <div style="height: 300px; display: flex; justify-content: center; align-items: center;">
                                <p>Pilih Pesan terlebih dahulu</p>
                            </div>
                        @endif
                    </div>

                </div>


                <div class="d-flex align-items-start p-2 rounded-3">



                </div>

            </div>


        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://kit.fontawesome.com/3b8c65f5c7.js" crossorigin="anonymous"></script>
    <script>
        document.getElementById('file-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('image-preview');

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    console.log(e.target.result)
                    // Menampilkan gambar dalam elemen pratinjau
                    previewContainer.style.display = 'block';
                    previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                };

                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
                previewContainer.innerHTML = '';
            }
        });

        // Fungsi untuk menggulir ke bawah
        function scrollToBottom() {
            const chatBox = document.getElementById('chat-box');
            if (chatBox) {
                setTimeout(() => {

                    chatBox.scrollTop = chatBox.scrollHeight;
                    console.log(chatBox);
                }, 500);
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Fungsi scrollToBottom akan dipanggil setelah DOM sepenuhnya dimuat
            scrollToBottom();
        });

        function sendMessage() {
            // Ambil data dari input form
            let message = document.getElementById('message').value;
            let attachment = document.getElementById('file-input').files[0];

            // Validasi input
            if (!message && !attachment) {
                alert('Pesan atau gambar harus diisi');
                return;
            }

            let formData = new FormData();
            formData.append('receiver_id', {{ $reciever }}); // Ganti dengan ID penerima sesuai kebutuhan
            formData.append('message', message);

            if (attachment) {
                formData.append('attachment', attachment);
            }

            // Kirim data ke backend via AJAX
            fetch('{{ route('chats') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Tampilkan pesan baru pada chat
                        let chatBox = document.getElementById('chat-box');
                        let newMessage = document.createElement('div');
                        newMessage.className = 'chat-message sent';
                        newMessage.innerHTML = `<p>${data.chat.message || ''}</p>`;

                        if (data.chat.attachment) {
                            newMessage.innerHTML +=
                                `<img src="/storage/${data.chat.attachment}" alt="Lampiran" style="max-width: 100%; height: auto; border-radius: 10px;">`;
                        }

                        chatBox.appendChild(newMessage);
                        chatBox.scrollTop = chatBox.scrollHeight; // Scroll ke bawah otomatis
                    } else {
                        alert('Gagal mengirim pesan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengirim pesan');
                });
        }


        // Fungsi untuk menampilkan pesan
        function loadChat(receiverId) {
            fetch(`/chat-response/${receiverId}`)
                .then(response => response.json())
                .then(data => {
                    const chatBox = document.getElementById('chat-box');
                    chatBox.innerHTML = ''; // Clear chat box
                    data.forEach(chat => {
                        const messageDiv = document.createElement('div');
                        messageDiv.classList.add('chat-message');
                        messageDiv.classList.add(chat.sender_id === {{ Auth::id() }} ? 'sent' : 'received');

                        if (chat.message) {
                            messageDiv.innerHTML = `<p>${chat.message}</p>`;
                        }
                        if (chat.attachment) {
                            messageDiv.innerHTML +=
                                `<img src="/storage/${chat.attachment}" alt="Lampiran" style="max-width: 100%; height: auto; border-radius: 10px;">`;
                        }

                        chatBox.appendChild(messageDiv);
                    });
                    chatBox.scrollTop = chatBox.scrollHeight; // Scroll ke bawah otomatis
                });
        }

        loadChat({{ $reciever }});
    </script>
@endsection
