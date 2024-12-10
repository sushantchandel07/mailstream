        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="" alt="" height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <div id="scrollbar">
                    <div class="container-fluid">

                        <div id="two-column-menu">
                        </div>
                        <ul class="navbar-nav" id="navbar-nav">

                            <div class="p-4 d-flex flex-column h-100">
                                <div class="pb-4 border-bottom border-bottom-dashed">
                                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#composemodal"><i data-feather="plus-circle" class="icon-xs me-1 icon-dual-light"></i> Compose</button>
                                </div>

                                <div class="mail-list mt-3">
                                    <a href="{{ route('mail.tab', ['tab' => 'all']) }}" class="{{ $tab === 'all' ? 'active' : '' }}">
                                        <i class="ri-mail-fill me-3 align-middle fw-medium"></i>
                                        <span class="mail-list-link">All</span>
                                    </a>

                                    <a href="{{ route('mail.tab', ['tab' => 'inbox']) }}" class="{{ $tab === 'inbox' ? 'active' : '' }}">
                                        <i class="ri-inbox-archive-fill me-3 align-middle fw-medium"></i>
                                        <span class="mail-list-link">Inbox</span>
                                    </a>
                                    <a href="{{ route('mail.tab', ['tab' => 'sent']) }}" class="{{ $tab === 'sent' ? 'active' : '' }}">
                                        <i class="ri-send-plane-2-fill me-3 align-middle fw-medium"></i>
                                        <span class="mail-list-link">Sent</span>
                                    </a>
                                    <a href="{{ route('mail.tab', ['tab' => 'draft']) }}" class="{{ $tab === 'draft' ? 'active' : '' }}">
                                        <i class="ri-edit-2-fill me-3 align-middle fw-medium"></i>
                                        <span class="mail-list-link">Draft</span>
                                    </a>
                                    <a href="{{ route('mail.tab', ['tab' => 'starred']) }}" class="{{ $tab === 'starred' ? 'active' : '' }}">
                                        <i class="ri-star-fill me-3 align-middle fw-medium"></i>
                                        <span class="mail-list-link">Starred</span>
                                    </a>
                                    <a href="{{ route('mail.tab', ['tab' => 'important']) }}" class="{{ $tab === 'important' ? 'active' : '' }}">
                                        <i class="ri-star-fill me-3 align-middle fw-medium"></i>
                                        <span class="mail-list-link">Important</span>
                                    </a>
                                    <a href="{{ route('mail.tab', ['tab' => 'spam']) }}" class="{{ $tab === 'spam' ? 'active' : '' }}">
                                        <i class="ri-spam-fill me-3 align-middle fw-medium"></i>
                                        <span class="mail-list-link">Spam</span>
                                    </a>
                                    <a href="{{ route('mail.tab', ['tab' => 'archive']) }}" class="{{ $tab === 'archive' ? 'active' : '' }}">
                                        <i class="ri-archive-fill me-3 align-middle fw-medium"></i>
                                        <span class="mail-list-link">Archive</span>
                                    </a>
                                    <a href="{{ route('mail.tab', ['tab' => 'trash']) }}" class="{{ $tab === 'trash' ? 'active' : '' }}">
                                        <i class="ri-delete-bin-5-fill me-3 align-middle fw-medium"></i>
                                        <span class="mail-list-link">Trash</span>
                                    </a>
                                </div>


                                <div>
                                    <div class="border-top border-top-dashed pt-3 mt-3">
                                        <div class="mt-2 vstack email-chat-list mx-n4">
                                        </div>
                                    </div>
                                    <h3 class="fs-12 text-uppercase text-muted mt-4 cursor-pointer" data-bs-toggle="modal" data-bs-target="#EmailLabel" onclick="openAddLabelForm()">
                                        Create Labels
                                    </h3>
                                    <div class=" d-flex justify-around gap-sm-1 align-items-center flex-wrap">
                                        <!-- <div class="pb-4 border-bottom border-bottom-dashed">
                                        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#composemodal"><i data-feather="plus-circle" class="icon-xs me-1 icon-dual-light"></i> Compose</button>
                                            </div> -->


                                        <h5 class="fs-12 text-uppercase text-muted mt-4 cursor-pointer">
                                            Labels
                                        </h5>

                                    </div>

                                    <div class="mail-list mt-1">
                                        @foreach($labels as $label)
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <a href="{{ route('quickmail.labels.emails', $label->id) }}" class="d-flex align-items-center text-decoration-none">
                                                <span class="ri-checkbox-blank-circle-line me-2 text-info"></span>
                                                <span class="mail-list-link" data-type="label">{{ $label->name }}</span>
                                            </a>

                                            <div class="dropdown">
                                                <button class="btn btn-ghost-secondary btn-icon shadow-none btn-sm fs-16" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill align-bottom"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Open</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EmailLabel" onclick="openEditLabelForm('{{ $label->name }}', '{{ $label->id }}')">Edit</a>
                                                    <!-- <a class="dropdown-item" href="#">Show If Unread </a> -->
                                                    <form method="POST" action="{{ route('quickmail.labels.destroy', $label->id) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this label?')">Remove</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>


                    </div>

            </ul>
        </div>

        <!-- Sidebar -->
        </div>

        </ul>


        <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->

        <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->

        <!-- Compose Modal-->
        <form method="POST" action="{{route('mail.store')}}">
            @csrf
            <input type="hidden" id="email_id" name="email_id">
            <input type="hidden" id="user_id" name="user_id" value="{{auth()->id()}}">
            <div class="modal fade" id="composemodal" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header p-3 bg-light">
                            <h5 class="modal-title" id="composemodalTitle">New Message</h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <div class="mb-3 position-relative">
                                    <input type="text" class="form-control email-compose-input @error('email') is-invalid @enderror" data-choices data-choices-limit="15" name="email" data-choices-removeItem placeholder="To" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="position-absolute top-0 end-0">
                                        <div class="d-flex">
                                            <button class="btn btn-link text-reset fw-semibold px-2" type="button" name="cc[]" data-bs-toggle="collapse" data-bs-target="#CcRecipientsCollapse" aria-expanded="false" aria-controls="CcRecipientsCollapse">
                                                Cc
                                            </button>
                                            <button class="btn btn-link text-reset fw-semibold px-2" type="button" name="bcc[]" data-bs-toggle="collapse" data-bs-target="#BccRecipientsCollapse" aria-expanded="false" aria-controls="BccRecipientsCollapse">
                                                Bcc
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="collapse" id="CcRecipientsCollapse">
                                    <div class="mb-3">
                                        <label>Cc:</label>
                                        <input type="text" class="form-control" data-choices data-choices-limit="15" name="cc" data-choices-removeItem placeholder="Cc recipients">
                                    </div>
                                </div>
                                <div class="collapse" id="BccRecipientsCollapse">
                                    <div class="mb-3">
                                        <label>Bcc:</label>
                                        <input type="text" class="form-control" data-choices data-choices-limit="15" name="bcc" data-choices-removeItem placeholder="Bcc recipients">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Subject" name="mail_subject" required>
                                </div>
                                <div class="ck-editor-reverse">
                                    <textarea type="text" placeholder="Body" class="form-control py-2" name="mail_body"></textarea>
                                    <!-- <textarea  id="editor" placeholder="Body" class="form-control py-2"  name="mail_body"></textarea> -->
                                    <div id="email-editor"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">Discard</button>

                            <div class="btn-group">
                                <button type="submit" class="btn btn-success">Send</button>
                                <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="ri-timer-line text-muted me-1 align-bottom"></i> Schedule Send</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script>
            let saveDraftTimer;

            document.querySelectorAll('input[name="email"], input[name="cc"], input[name="bcc"], input[name="mail_subject"], textarea[name="mail_body"]').forEach((input) => {
                input.addEventListener('input', () => {
                    clearTimeout(saveDraftTimer);
                    saveDraftTimer = setTimeout(saveDraft, 1000);
                });
            });

            function saveDraft() {
                const formData = new FormData();
                formData.append('email', document.querySelector('input[name="email"]').value);
                formData.append('cc', document.querySelector('input[name="cc"]').value);
                formData.append('bcc', document.querySelector('input[name="bcc"]').value);
                formData.append('mail_subject', document.querySelector('input[name="mail_subject"]').value);
                formData.append('mail_body', document.querySelector('textarea[name="mail_body"]').value);

                const draftId = document.getElementById('email_id').value;
                if (draftId) {
                    formData.append('email_id', draftId);
                }

                fetch("{{ route('mail.draft') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => response.json())
                    .then(data => {
                        console.log('Draft saved', data);
                        if (data.email_id) {
                            document.getElementById('email_id').value = data.email_id;
                        }
                    })
                    .catch(error => console.error('Error saving draft:', error));
            }
        </script>
        <!-- end modal -->

        <form method="POST" id="labelForm">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal fade" id="EmailLabel" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header p-3 bg-light">
                            <h5 class="modal-title" id="composemodalTitle">Add Label</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3 position-relative">
                                <input type="text" class="form-control email-compose-input" data-choices data-choices-limit="15" name="label" data-choices-removeItem placeholder="Add Here" id="labelInput" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">Discard</button>
                            <button type="submit" class="btn btn-success" id="submitButton">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <script>
            function openAddLabelForm() {
                document.getElementById('labelInput').value = '';
                document.getElementById('labelForm').action = "{{ route('quickmail.labels') }}";
                document.getElementById('formMethod').value = "POST";
                document.getElementById('composemodalTitle').innerText = 'Add Label';
                document.getElementById('submitButton').innerText = 'Add';
            }

            function openEditLabelForm(labelName, labelId) {
                document.getElementById('labelInput').value = labelName;
                document.getElementById('labelForm').action = "/labels/" + labelId;
                document.getElementById('formMethod').value = "PUT";
                document.getElementById('composemodalTitle').innerText = 'Edit Label';
                document.getElementById('submitButton').innerText = 'Update';
            }
        </script>

        <!-- removeItemModal -->
        <div id="removeItemModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-2 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                <h4>Are you Sure ?</h4>
                                <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record ?</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn w-sm btn-danger " id="delete-record">Yes, Delete It!</button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->



        <!--start back-to-top-->
        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->

        <!--preloader-->
        <div id="preloader">
            <div id="status">
                <!-- <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div> -->
            </div>
        </div>

        <div class="customizer-setting d-none d-md-block">
            <div class="btn-info rounded-pill shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
                <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
            </div>
        </div>

        <!-- Theme Settings -->





        <!-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Understood</button>
                    </div>
                </div>
            </div>
        </div> -->