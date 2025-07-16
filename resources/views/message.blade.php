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
                                                All messages <span class="opn-no">25</span>
                                            </button>
                                            <button class="btn btn-cat" data-cat-source="cat-1">
                                                Archived <span class="opn-no">25</span>
                                            </button>
                                            <button class="btn btn-cat" data-cat-source="cat-2">
                                                Starred <span class="opn-no">4</span>
                                            </button>
                                        </div>
                                        <button class="nav-link active portfolio-block" id="cat-1" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-home" type="button" role="tab"
                                            aria-controls="v-pills-home" aria-selected="true">


                                            <div class="imag-pic-div015">
                                                <img src="{{ asset('/assets/images/avatar.svg') }}" alt="">
                                            </div>
                                            <div class="text-details015">
                                                <h5 class="d-flex align-items-center justify-content-between"> Liam
                                                    Smith <span>15 min</span> </h5>
                                                <p class="namet">Lorem ipsum dolor sit amet consectetur. Nunc tellus non
                                                    arcu elementum.</p>
                                            </div>

                                        </button>
                                        <button class="nav-link portfolio-block" id="cat-2" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-profile" type="button" role="tab"
                                            aria-controls="v-pills-profile" aria-selected="false">
                                            <div class="imag-pic-div015">
                                                <img src="{{ asset('assets/images/avatar.svg') }}" alt="">
                                            </div>
                                            <div class="text-details015">
                                                <h5 class="d-flex align-items-center justify-content-between"> Liam
                                                    Smith <span>15 min</span> </h5>
                                                <p class="namet">Lorem ipsum dolor sit amet consectetur. Nunc tellus non
                                                    arcu elementum.</p>
                                            </div>
                                        </button>
                                        <button class="nav-link portfolio-block" id="cat-1" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-messages" type="button" role="tab"
                                            aria-controls="v-pills-messages" aria-selected="false">

                                            <div class="imag-pic-div015">
                                                <img src="{{ asset('assets/images/avatar.svg') }}" alt="">
                                            </div>
                                            <div class="text-details015">
                                                <h5 class="d-flex align-items-center justify-content-between"> Liam
                                                    Smith <span>15 min</span> </h5>
                                                <p class="namet">Lorem ipsum dolor sit amet consectetur. Nunc tellus non
                                                    arcu elementum.</p>
                                            </div>
                                        </button>
                                        <button class="nav-link portfolio-block" id="cat-1" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-settings" type="button" role="tab"
                                            aria-controls="v-pills-settings" aria-selected="false">

                                            <div class="imag-pic-div015">
                                                <img src="{{ asset('asset/images/avatar.svg') }}" alt="">
                                            </div>
                                            <div class="text-details015">
                                                <h5 class="d-flex align-items-center justify-content-between"> Liam
                                                    Smith <span>15 min</span> </h5>
                                                <p class="namet">Lorem ipsum dolor sit amet consectetur. Nunc tellus non
                                                    arcu elementum.</p>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 pe-0">
                            <div class="right-bg-div015 position-relative">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                        aria-labelledby="v-pills-home-tab">

                                        <div class="tops-chats-div015 header-div">
                                            <h2>Liam Smith</h2>
                                        </div>
                                        <ul class="chat-body">
                                            <li>
                                                <div class="comon-feeds015 position-relative d-flex align-items-start">
                                                    <div class="user-pic0125">
                                                        <img src="{{ asset('assets/images/avatar.svg') }}" alt="">
                                                    </div>
                                                    <div class="das-tparat">
                                                        <div class="dm-texts">
                                                            <p class="message-box"> Lorem ipsum dolor sit amet
                                                                consectetur. Nunc tellus <br> non
                                                                arcu
                                                                elementum. </p>
                                                        </div>
                                                        <h6 class="">10:00 AM</h6>
                                                    </div>


                                                </div>
                                            </li>



                                            <li>
                                                <div class="comon-feeds015 position-relative d-flex align-items-start">
                                                    <div class="user-pic0125">
                                                        <img src="{{ asset('assets/images/avatar.svg') }}" alt="">
                                                    </div>
                                                    <div class="das-tparat">
                                                        <div class="dm-texts d-flex gap-2">

                                                            <img src="{{ asset('assets/images/mes-doc.svg') }}" alt="">
                                                            <div>
                                                                <p class="message-box-doc">Invoice </p>
                                                                <p class="doc d-flex justify-content-between gap-3">
                                                                    <span>PDF</span> <span>1,7 MB</span>
                                                                </p>
                                                            </div>

                                                        </div>
                                                        <h6 class="">10:00 AM</h6>
                                                    </div>


                                                </div>
                                            </li>





                                            <li>
                                                <div class="comon-feeds015 position-relative d-flex align-items-start">
                                                    <div class="user-pic0125">
                                                        <img src="{{ asset('assets/images/avatar.svg') }}" alt="">
                                                    </div>
                                                    <div class="das-tparat">
                                                        <div class="dm-texts">
                                                            <img src="{{ asset('assets/images/dog-img.png') }}" alt="">
                                                            <img src="{{ asset('assets/images/dog-img.png') }}" alt="">
                                                            <img src="{{ asset('assets/images/dog-img.png') }}" alt="">
                                                            <p class="message-box"> Lorem ipsum dolor sit amet
                                                                consectetur. Nunc tellus <br> non
                                                                arcu
                                                                elementum. </p>
                                                        </div>
                                                        <h6 class="">10:00 AM</h6>
                                                    </div>


                                                </div>
                                            </li>

                                            <li>
                                                <div
                                                    class="comon-feeds-right position-relative d-flex align-items-start">

                                                    <div class="das-tparat-right">
                                                        <div class="dm-texts-right">
                                                            <p class="message-box-right"> Lorem ipsum dolor sit amet
                                                                consectetur. Nunc tellus <br> non
                                                                arcu
                                                                elementum. </p>
                                                        </div>
                                                        <h6 class="right-ms-timestamp">10:00 AM</h6>
                                                    </div>
                                                    <div class="user-pic0125-right">
                                                        <img src="{{ asset('assets/images/avatar.svg') }}" alt="">
                                                    </div>

                                                </div>
                                            </li>








                                        </ul>

                                    </div>
                                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                        aria-labelledby="v-pills-profile-tab">
                                        <div class="tops-chats-div015">
                                            <h2>Liam Smith</h2>
                                        </div>
                                        <div class="comon-feeds015 position-relative d-flex align-items-start">
                                            <div class="user-pic0125">
                                                <img src="{{ asset('assets/images/avatar.svg') }}" alt="">
                                            </div>
                                            <div class="das-tparat">
                                                <div class="dm-texts">
                                                    <p> Lorem ipsum dolor sit amet consectetur. Nunc tellus non arcu
                                                        elementum. </p>
                                                </div>
                                                <h6>10:00 AM</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                        aria-labelledby="v-pills-messages-tab">
                                        <div class="tops-chats-div015">
                                            <h2>Liam Smith</h2>
                                        </div>
                                        <div class="comon-feeds015 position-relative d-flex align-items-start">
                                            <div class="user-pic0125">
                                                <img src="{{ asset('assets/images/avatar.svg') }}" alt="">
                                            </div>
                                            <div class="das-tparat">
                                                <div class="dm-texts">
                                                    <p> Lorem ipsum dolor sit amet consectetur. Nunc tellus non arcu
                                                        elementum. </p>
                                                </div>
                                                <h6>10:00 AM</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                        aria-labelledby="v-pills-settings-tab">
                                        <div>

                                        </div>
                                        <div class="tops-chats-div015">
                                            <h2>Liam Smith</h2>
                                        </div>
                                        <div class="comon-feeds015 position-relative d-flex align-items-start">
                                            <div class="user-pic0125">
                                                <img src="{{ asset('assets/images/avatar.svg') }}" alt="">
                                            </div>
                                            <div class="das-tparat">
                                                <div class="dm-texts">
                                                    <p> Lorem ipsum dolor sit amet consectetur. Nunc tellus non arcu
                                                        elementum. </p>
                                                </div>
                                                <h6>10:00 AM</h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="chart-sections-div d-block w-100 position-relative">
                                        <div id="editor-container"></div>
                                        <div
                                            class="bottom-parts w-100 d-flex align-items-center justify-content-between">
                                            <div id="toolbar" class="d-flex align-items-center justify-content-between">
                                                <div class="me-auto">
                                                    <button class="ql-bold">
                                                    </button>
                                                    <button class="ql-italic"></button>
                                                    <button class="ql-underline"></button>
                                                    <button class="ql-list" value="ordered"></button>
                                                    <button class="ql-list" value="bullet"></button>
                                                </div>
                                                <div class="ms-auto">
                                                    <button class="ql-emoji">
                                                        <img src="{{ asset('assets/images/emoji.svg') }}" alt="">
                                                    </button>
                                                    <button id="attach-file-btn">
                                                        <img src="{{asset('assets/images/attach.svg') }}" alt="nam" />
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-send"> <span> <img
                                                        src="{{  asset('assets/images/Send.svg') }}" alt="nam" />
                                                </span> Send </button>
                                        </div>
                                        <input type="file" id="file-input" />
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>






    </main>





</body>
<x-footer />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-XR5QoDN+YyA7PvKjqYkLgTjKkIvBPDRHdR2EUqgNLo+goAqACyMP+cIk/FWjjfLy" crossorigin="anonymous">
</script>

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
const quill = new Quill('#editor-container', {
    modules: {
        toolbar: {
            container: "#toolbar"
        },
        "emoji-toolbar": true,
        "emoji-textarea": false,
        "emoji-shortname": true
    },
    theme: 'snow'
});


const fileInput = document.getElementById('file-input');
const attachBtn = document.getElementById('attach-file-btn');

attachBtn.addEventListener('click', () => {
    fileInput.click();
});

fileInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (!file) return;

    // Simulate a file upload and return a blob URL (for demo)
    const url = URL.createObjectURL(file);
    const fileName = file.name;

    // Insert a link into the editor
    const range = quill.getSelection();
    const linkHtml = `<a href="${url}" target="_blank">${fileName}</a>`;
    quill.clipboard.dangerouslyPasteHTML(range ? range.index : 0, linkHtml);

    // Clear input
    fileInput.value = '';
});
</script>









</html>