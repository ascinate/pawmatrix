<x-header />

<body class="all-bg message-pages">
    <main class="float-start w-100">
        <x-sidebar />
        <section class="left-sections-right float-end pt-0 pe-0">
            <div class="row p-0 m-0">
                <div class="col-lg-12 pe-0">
                    <div class="row m-0">
                        <div class="col-lg-4 mt-4">
                            <div class="search-sections01 w-100 ps-0 d-block">
                                <div class="form-group search-inputs ps-2 d-flex align-items-center">
                                    <button class="btn"> <i class="ri-search-2-line"></i> </button>
                                    <input type="search" class="form-control" placeholder="Search" />
                                </div>

                                <div class="filters-sections01">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                        aria-orientation="vertical">
                                        <div class="categories-filter">
                                            <button class="btn btn-cat active" data-cat-source="all">
                                                All messages <span class="opn-no">{{ count($conversations) }}</span>
                                            </button>
                                            <button class="btn btn-cat" data-cat-source="cat-1">
                                                Archived <span class="opn-no">0</span>
                                            </button>
                                            <button class="btn btn-cat" data-cat-source="cat-2">
                                                Starred <span class="opn-no">0</span>
                                            </button>
                                        </div>
                                        @foreach ($conversations as $index => $conversation)
                                        <button class="nav-link portfolio-block {{ $loop->first ? 'active' : '' }}"
                                            id="cat-{{$conversation['id']}}" data-bs-toggle="pill"
                                            data-bs-target="#chat-{{$conversation['id'] }}" type="button" role="tab"
                                            aria-controls="chat-{{ $conversation['id']}}"
                                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                            <div class="imag-pic-div015">
                                                <img src="{{ asset('assets/images/avatar.svg') }}" alt="">
                                            </div>
                                            <div class="text-details015">
                                                <h5 class="d-flex align-items-center justify-content-between">
                                                    {{ $conversation['name']}}
                                                    <span>{{ $conversation['last_message_time'] }}</span>
                                                </h5>
                                                <p class="namet">
                                                    {{ \Illuminate\Support\Str::limit($conversation['last_message'], 40) }}
                                                </p>
                                            </div>
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 pe-0">
                            <div class="right-bg-div015 position-relative">
                                <div class="tab-content" id="v-pills-tabContent">
                                    @foreach ($conversations as $conversation)
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                        id="chat-{{ $conversation['id'] }}" role="tabpanel"
                                        aria-labelledby="chat-{{$conversation['id'] }}-tab">
                                        <div class="tops-chats-div015 header-div">
                                            <h2>{{ $conversation['name'] }}</h2>
                                        </div>
                                        <ul class="chat-body">
                                            @foreach($conversation['messages'] as $message)
                                            <li>
                                                @if($message->sender_type == ($isClient ? 'client' : 'user'))
                                                <div class="comon-feeds-right position-relative d-flex align-items-start">
                                                    <div class="das-tparat-right">
                                                        <div class="dm-texts-right">
                                                            <p class="message-box-right">{!! $message->message !!}</p>
                                                        </div>
                                                        <h6 class="right-ms-timestamp">{{ $message->created_at->format('h:i A') }}</h6>
                                                    </div>
                                                    <div class="user-pic0125-right">
                                                        <img src="{{ asset('assets/images/avatar.svg') }}" alt="">
                                                    </div>
                                                </div>
                                                @else
                                                <div class="comon-feeds015 position-relative d-flex align-items-start">
                                                    <div class="user-pic0125">
                                                        <img src="{{ asset('assets/images/avatar.svg') }}" alt="">
                                                    </div>
                                                    <div class="das-tparat">
                                                        <div class="dm-texts">
                                                            <p class="message-box">{!! $message->message !!}</p>
                                                        </div>
                                                        <h6>{{ $message->created_at->format('h:i A') }}</h6>
                                                    </div>
                                                </div>
                                                @endif
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endforeach
                                </div>

                                <form action="{{ route('messages.send') }}" method="POST" id="global-chat-form">
                                    @csrf
                                    <input type="hidden" name="recipient_id" id="global-recipient-id">
                                    <input type="hidden" name="recipient_type" id="global-recipient-type">
                                    <input type="hidden" name="message" id="global-hidden-message">

                                    <div class="chart-sections-div d-block w-100 position-relative">
                                        <div id="global-editor-container"></div>
                                        <div class="bottom-parts w-100 d-flex align-items-center justify-content-between">
                                            <div id="global-toolbar" class="d-flex align-items-center justify-content-between">
                                                <div class="me-auto">
                                                    <button class="ql-bold" title="Bold"></button>
                                                    <button class="ql-italic" title="Italic"></button>
                                                    <button class="ql-underline" title="Underline"></button>
                                                    <button class="ql-list" value="ordered" title="Numbered List"></button>
                                                    <button class="ql-list" value="bullet" title="Bullet List"></button>
                                                </div>
                                                <div class="ms-auto">
                                                    <button class="ql-emoji" title="Emoji">
                                                        <img src="{{ asset('assets/images/emoji.svg') }}" alt="Emoji">
                                                    </button>
                                                    <button type="button" id="attach-file-btn" title="Attach File">
                                                        <img src="{{ asset('assets/images/attach.svg') }}" alt="Attach" />
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-send" onclick="submitGlobalMessage()">
                                                <span><img src="{{ asset('assets/images/Send.svg') }}" alt="send"></span> Send
                                            </button>
                                        </div>
                                        <input type="file" id="file-input" style="display: none;">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-XR5QoDN+YyA7PvKjqYkLgTjKkIvBPDRHdR2EUqgNLo+goAqACyMP+cIk/FWjjfLy" crossorigin="anonymous">
    </script>

    <script>
    $(document).ready(function() {
        new DataTable('#example', {
            responsive: true,
            searching: false,
            lengthChange: false
        });
    });
    </script>

    <script>
    $(document).on('click', '.btn-cat', function(e) {
        var $type = $(this).data("cat-source");
        if ($type == "all") {
            $('.portfolio-block').fadeOut(0);
            $('.portfolio-block').fadeIn(1000);
        } else {
            $('.portfolio-block').hide();
            $('#' + $type + ".portfolio-block").fadeIn(1000);
        }
    })

    $(document).ready(function() {
        var selector = '.categories-filter button';

        $(selector).on('click', function() {
            $(selector).removeClass('active');
            $(this).addClass('active');
        });
    })
    </script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill-emoji@0.1.7/dist/quill-emoji.js"></script>
    <script>
    let globalQuill;

    document.addEventListener("DOMContentLoaded", function() {
        // Initialize ONE editor
        globalQuill = new Quill('#global-editor-container', {
            modules: {
                toolbar: {
                    container: "#global-toolbar"
                },
                "emoji-toolbar": true,
                "emoji-textarea": false,
                "emoji-shortname": true
            },
            theme: 'snow'
        });

        // Handle tab switch
        const chatTabs = document.querySelectorAll('[data-bs-toggle="pill"]');
        chatTabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', function() {
                const targetId = tab.getAttribute('data-bs-target').replace('#chat-', '');
                const conversation = @json($conversations);
                const current = conversation.find(c => c.id == targetId);

                document.getElementById('global-recipient-id').value = current.id;
                document.getElementById('global-recipient-type').value = current.recipient_type;

                // Optional: clear editor on switch
                globalQuill.setContents([]);
            });
        });

        // Set initial recipient
        const firstTab = document.querySelector('[data-bs-toggle="pill"]');
        if (firstTab) firstTab.dispatchEvent(new Event('shown.bs.tab'));
    });

    function submitGlobalMessage() {
        const content = globalQuill.root.innerHTML.trim();
        if (!content || content === '<p><br></p>') return;

        document.getElementById('global-hidden-message').value = content;
        document.getElementById('global-chat-form').submit();
    }

    // File Upload Simulation
    document.getElementById('attach-file-btn').addEventListener('click', () => {
        document.getElementById('file-input').click();
    });

    document.getElementById('file-input').addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;
        const url = URL.createObjectURL(file);
        const fileName = file.name;
        const range = globalQuill.getSelection();
        const linkHtml = `<a href="${url}" target="_blank">${fileName}</a>`;
        globalQuill.clipboard.dangerouslyPasteHTML(range ? range.index : 0, linkHtml);
        e.target.value = '';
    });
    </script>
</body>
</html>