@extends('quickmail::layouts.app')
@section('content')
<div class="main-content">

    <div class="container-fluid">

        <div class="email-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">

            <div class="email-content">
                <div class="p-4 pb-0">
                    <div class="border-bottom border-bottom-dashed">
                        <div class="row mt-n2 mb-3 mb-sm-0">
                            <div class="col col-sm-auto order-1 d-block d-lg-none">
                                <button type="button" class="btn btn-soft-success btn-icon btn-sm fs-16 email-menu-btn">
                                    <i class="ri-menu-2-fill align-bottom"></i>
                                </button>
                            </div>
                            <div class="col-sm order-3 order-sm-2">
                                <div class="hstack gap-sm-1 align-items-center flex-wrap email-topbar-link">
                                    <div class="form-check fs-14 m-0">
                                        <input class="form-check-input" type="checkbox" value="" id="checkall">
                                        <label class="form-check-label" for="checkall"></label>
                                    </div>
                                    <div id="email-topbar-actions">
                                        <div class="hstack gap-sm-1 align-items-center flex-wrap">
                                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm shadow-none fs-16" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Archive">
                                                <i class="ri-inbox-archive-fill align-bottom"></i>
                                            </button>
                                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm shadow-none fs-16" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Report Spam">
                                                <i class="ri-error-warning-fill align-bottom"></i>
                                            </button>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Trash">
                                                <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm shadow-none fs-16" data-bs-toggle="modal" data-bs-target="#removeItemModal">
                                                    <i class="ri-delete-bin-5-fill align-bottom"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vr align-self-center mx-2"></div>
                                    <div class="dropdown">
                                        <button class="btn btn-ghost-secondary btn-icon shadow-none btn-sm fs-16" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ri-price-tag-3-fill align-bottom"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <select id="label-select" class="form-select">
                                                <option>Select Label</option>
                                                @foreach ($labels as $label)
                                                <option value="{{ $label->id }}">{{ ucfirst($label->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-ghost-secondary shadow-none btn-icon btn-sm fs-16" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ri-more-2-fill align-bottom"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#" id="mark-all-read">Mark as Read</a>
                                        </div>
                                    </div>
                                    <div class="alert alert-warning alert-dismissible unreadConversations-alert px-4 fade show " id="unreadConversations" role="alert">
                                        No Unread Conversations
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto order-2 order-sm-3">
                                <div class="d-flex gap-sm-1 email-topbar-link">
                                    <button type="button" class="btn btn-ghost-secondary btn-icon shadow-none btn-sm fs-16">
                                        <i class="ri-refresh-line align-bottom"></i>
                                    </button>
                                    <div class="dropdown">
                                        <button class="btn btn-ghost-secondary btn-icon shadow-none btn-sm fs-16" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ri-more-2-fill align-bottom"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#" id="mark-all-unread">Mark as Unread</a>
                                            <a class="dropdown-item" href="#" id="mark-as-important">Mark as Important</a>
                                            <a class="dropdown-item" href="#">Add to Tasks</a>
                                            <a class="dropdown-item" href="#">Trash</a>
                                            <a class="dropdown-item" href="#">Mute</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-end mt-3">
                            <div class="col">
                                <div id="mail-filter-navlist">
                                    <ul class="nav nav-tabs nav-tabs-custom gap-1 text-center border-bottom-0" role="tablist">
                                        <li class="nav-item">
                                            <button class="nav-link fw-semibold active" id="pills-primary-tab" data-bs-toggle="pill" data-bs-target="#pills-primary" type="button" role="tab" aria-controls="pills-primary" aria-selected="true">
                                                <i class="ri-inbox-fill align-bottom d-inline-block"></i>
                                                <span class="ms-1 d-none d-sm-inline-block">Primary</span>
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link fw-semibold" id="pills-social-tab" data-bs-toggle="pill" data-bs-target="#pills-social" type="button" role="tab" aria-controls="pills-social" aria-selected="false">
                                                <i class="ri-group-fill align-bottom d-inline-block"></i>
                                                <span class="ms-1 d-none d-sm-inline-block">Social</span>
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link fw-semibold" id="pills-promotions-tab" data-bs-toggle="pill" data-bs-target="#pills-promotions" type="button" role="tab" aria-controls="pills-promotions" aria-selected="false">
                                                <i class="ri-price-tag-3-fill align-bottom d-inline-block"></i>
                                                <span class="ms-1 d-none d-sm-inline-block">Promotions</span>
                                            </button>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                            <div class="col-auto">
                                <!-- <div class="text-muted mb-2">1-50 of 154</div> -->
                            </div>
                        </div>
                    </div>

                    @foreach ($emails as $email)
                    <ul class="message-list" id="social-mail-list">
                        <li class="{{ $email->is_read ? 'read-email' : 'unread-email' }}">

                            <div class="col-mail col-mail-1">
                                <div class="form-check checkbox-wrapper-mail fs-14">
                                    <input class="form-check-input email-checkbox" type="checkbox"
                                        data-email-id="{{ $email->id }}">
                                    <label class="form-check-label" for="checkbox"></label>
                                </div>
                                <input type="hidden" class="mail-userimg" />
                                <button type="button"
                                    class="btn btn-ghost-secondary btn-icon btn-sm shadow-none fs-16 favourite-btn
                                    {{ ($email->is_draft && $email->draft_is_starred) || (!$email->is_draft && $email->is_starred) ? 'active' : '' }}"
                                    data-email-id="{{ $email->id }} ">
                                    <i class="ri-star-fill align-bottom"></i>
                                </button>
                                @if ($tab === 'sent')
                                <a class="title">To:
                                    {{ $email->recipient_id == Auth::id() ? 'Me' : ucfirst($email->recipient_name) }}</a>
                                @elseif($tab === 'draft')
                                <a class="title"><span style="color: red;">Draft</span>
                                    {{ $email->recipient_id == Auth::id() ? 'Me' : ucfirst($email->recipient_name) }}</a>
                                @else
                                <a class="title">
                                    {{ $email->recipient_id == Auth::id() ? 'Me' : ucfirst($email->recipient_name) }}</a>
                                @endif
                            </div>
                            <div class="col-mail col-mail-2">
                                <a href="#" class="subject email-subject"
                                    data-email-id="{{ $email->id }}"
                                    data-email-recipient-id="{{ $email->recipient_id }}"
                                    data-email-recipient-name="{{ $email->recipient_name }}"
                                    data-recipient-email="{{ $email->recipient_name }}"
                                    data-email-subject="{{ $email->mail_subject }}"
                                    data-email-body="{{ $email->mail_body }}"
                                    data-is-draft="{{ $tab === 'all' ? ($email->is_draft ? 'true' : 'false') : ($tab === 'draft' ? 'true' : 'false') }}">
                                    @if ($tab === 'inbox' && !$email->is_read)
                                    <b>{{ ucfirst($email->mail_subject) }}</b> -
                                    {{ ucfirst($email->mail_body) }}
                                    @else
                                    {{ ucfirst($email->mail_subject) }} - {{ ucfirst($email->mail_body) }}
                                    @endif
                                </a>
                                <div class="date">{{ $email->created_at->format('j M') }}</div>
                            </div>
                        </li>
                    </ul>
                    @endforeach

                    <!-- Modals showing the draft mail and other mails  -->
                    <form method="POST" action="{{route('mail.store')}}">
                        @csrf
                        <input type="hidden" id="user_id" name="user_id" value="{{auth()->id()}}">
                        <div class="modal fade" id="ShowDraftMails" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header p-3 bg-light">
                                        <h5 class="modal-title" id="composemodalTitle">Draft Email</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <div class="mb-3 position-relative">
                                                <input type="text" class="form-control email-compose-input" data-choices data-choices-limit="15" name="email" data-choices-removeItem placeholder="To">
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
                                                <input type="text" class="form-control" placeholder="Subject" name="mail_subject">
                                            </div>
                                            <div class="ck-editor-reverse">
                                                <textarea type="text" placeholder="Body" class="form-control py-2" name="mail_body"></textarea>
                                                <!-- <textarea  id="editor" placeholder="Body" class="form-control py-2"  name="mail_body"></textarea> -->
                                                <div id="email-editor"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Send</button>
                                        <!-- <button type="button" class="btn btn-primary" onclick="saveDataDraft()">Save Draft</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <form action="" id="ShowEmail" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        <div class="modal fade" id="AllMails" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header p-3 bg-light">
                                        <h5 class="modal-title" id="composemodalTitle">Email</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3 position-relative">
                                            <!-- Email content goes here -->
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- Forward Button -->
                                        <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">Forward</button>

                                        <!-- Reply Button -->
                                        <button type="button" class="btn btn-success" id="replyButton">Reply</button>

                                        <!-- Trash Button -->
                                        <button type="submit" class="btn btn-danger" id="trashButton">
                                            <i class="ri-delete-bin-5-fill me-3 align-middle fw-medium"></i><span>Trash</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const markAllUnreadBtn = document.getElementById('mark-all-unread');
                            const markAsImportantBtn = document.getElementById('mark-as-important');
                            const markAllReadBtn = document.getElementById('mark-all-read');

                            function handleEmailAction(action) {
                                const selectedEmails = Array.from(document.querySelectorAll('.email-checkbox:checked')).map(checkbox => checkbox.dataset.emailId);

                                if (selectedEmails.length === 0) {
                                    alert('Please select at least one email.');
                                    return;
                                }

                                fetch('/emails/action', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        },
                                        body: JSON.stringify({
                                            email_ids: selectedEmails,
                                            action: action,
                                        }),
                                    })
                                    .then(response => response.json())
                                    .then(data => alert(data.message))
                                    .catch(error => console.error('Error:', error));
                            }

                            if (markAllUnreadBtn) {
                                markAllUnreadBtn.addEventListener('click', () => handleEmailAction('mark_as_unread'));
                            }

                            if (markAsImportantBtn) {
                                markAsImportantBtn.addEventListener('click', () => handleEmailAction('mark_as_important'));
                            }

                            if (markAllReadBtn) {
                                markAllReadBtn.addEventListener('click', () => handleEmailAction('mark_as_read'));
                            }
                        });

                        document.getElementById('trashButton').addEventListener('click', function(event) {
                            event.preventDefault();
                            document.getElementById('formMethod').value = 'POST';
                            document.getElementById('ShowEmail').action = '/trash-email';
                            document.getElementById('ShowEmail').submit();
                        });
                        document.getElementById('label-select').addEventListener('change', function(e) {
                            // Get the selected label ID
                            const labelId = this.value;

                            if (!labelId) {
                                alert('Please select a valid label.');
                                return;
                            }

                            // Collect all checked email IDs
                            const checkedEmails = Array.from(document.querySelectorAll('.email-checkbox:checked'))
                                .map(checkbox => checkbox.dataset.emailId);

                            if (checkedEmails.length === 0) {
                                alert('Please select at least one email to label.');
                                // Reset the dropdown
                                this.selectedIndex = 0;
                                return;
                            }

                            // Send the request to the server
                            fetch('/emails/assign-label', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    },
                                    body: JSON.stringify({
                                        mail_id: checkedEmails,
                                        label_id: labelId,
                                    }),
                                })
                                .then((response) => response.json())
                                .then((data) => {
                                    if (data.success) {
                                        alert('Emails labeled successfully.');
                                        // Optionally, refresh the page or update the UI
                                    } else {
                                        alert(data.message || 'Failed to label emails.');
                                    }
                                })
                                .catch((error) => {
                                    console.error('Error:', error);
                                    alert('An error occurred while labeling emails.');
                                })
                                .finally(() => {
                                    // Reset the dropdown after action
                                    this.selectedIndex = 0;
                                });
                        });

                        document.addEventListener('DOMContentLoaded', function() {
                            const emailSubjects = document.querySelectorAll('.email-subject');
                            emailSubjects.forEach(subject => {
                                subject.addEventListener('click', function(e) {
                                    e.preventDefault();

                                    const isDraft = this.getAttribute('data-is-draft') === 'true';
                                    const emailId = this.getAttribute('data-email-id');
                                    const recipientName = this.getAttribute('data-email-recipient-name');
                                    const emailSubject = this.getAttribute('data-email-subject');
                                    const emailBody = this.getAttribute('data-email-body');

                                    if (isDraft) {
                                        // Populate the Draft Modal   
                                        document.getElementById('email_id').value = emailId;
                                        document.querySelector('#ShowDraftMails input[name="email"]').value = recipientName;
                                        document.querySelector('#ShowDraftMails input[name="mail_subject"]').value = emailSubject;
                                        document.querySelector('#ShowDraftMails textarea[name="mail_body"]').value = emailBody;


                                        const draftModal = new bootstrap.Modal(document.getElementById('ShowDraftMails'));
                                        draftModal.show();
                                    } else {
                                        // Populate the All Mails Modal
                                        document.querySelector('#AllMails .modal-body').innerHTML = `
                                        <p><strong>Subject:</strong> ${emailSubject}</p>
                                        <p><strong>From:</strong> ${recipientName}</p>
                                        <p><strong>Body:</strong></p>
                                        <input type="hidden" name="email_id" id="email_id" value="${emailId}">
                                        <p>${emailBody}</p>
                                    `;
                                        const allMailsModal = new bootstrap.Modal(document.getElementById('AllMails'));
                                        allMailsModal.show();
                                    }
                                });
                            });
                        });
                        document.addEventListener('DOMContentLoaded', function() {
                            let saveDraftTimer;
                            const inputs = document.querySelectorAll('#ShowDraftMails input[name="email"], #ShowDraftMails input[name="mail_subject"], #ShowDraftMails textarea[name="mail_body"]');
                            inputs.forEach(input => {
                                input.addEventListener('input', () => {
                                    clearTimeout(saveDraftTimer);
                                    saveDraftTimer = setTimeout(saveDataDraft, 1000); // Debounce time of 1 second
                                });
                            });

                            function saveDataDraft() {
                                const formData = new FormData();
                                formData.append('email', document.querySelector('#ShowDraftMails input[name="email"]').value || '');
                                formData.append('mail_subject', document.querySelector('#ShowDraftMails input[name="mail_subject"]').value || '');
                                formData.append('mail_body', document.querySelector('#ShowDraftMails textarea[name="mail_body"]').value || '');

                                const draftId = document.getElementById('email_id').value;
                                if (draftId) {
                                    formData.append('email_id', draftId);
                                }

                                fetch("{{ route('mail.draft') }}", {
                                        method: 'POST',
                                        body: formData,
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        },
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        console.log('Draft saved', data);
                                        if (data.email_id) {
                                            document.getElementById('email_id').value = data.email_id;
                                        }
                                    })
                                    .catch(error => console.error('Error saving draft:', error));
                            }
                        });


                        document.querySelectorAll('.favourite-btn').forEach(button => {
                            button.addEventListener('click', function() {
                                const emailId = this.dataset.emailId;
                                const isStarred = this.classList.contains('active') ? false : true;

                                fetch(`/emails/${emailId}/toggle-star`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                        },
                                        body: JSON.stringify({
                                            is_starred: isStarred
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            this.classList.toggle('active', isStarred);
                                        } else {
                                            alert('Failed to update star status');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('An error occurred while updating star status');
                                    });
                            });
                        });
                    </script>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pills-primary" role="tabpanel" aria-labelledby="pills-primary-tab">
                            <div class="message-list-content mx-n4 px-4 message-list-scroll">
                                <!-- <div class="email-list">
                                @foreach ($emails as $email)
                                    <div class="email-item d-flex justify-content-around">
                                        <h3>{{ $email->mail_subject }}</h3>
                                        <p>{{ $email->mail_body }}</p>
                                        <small>Sent at: {{ $email->created_at->format('Y-m-d H:i') }}</small>
                                    </div>
                                @endforeach
                            </div> -->
                                <!-- <div id="elmLoader">
                                    <div class="spinner-border text-primary avatar-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>  -->
                                <ul class="message-list" id="mail-list"></ul>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-social" role="tabpanel" aria-labelledby="pills-social-tab">
                            <div class="message-list-content mx-n4 px-4 message-list-scroll">
                                <ul class="message-list" id="social-mail-list"></ul>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-promotions" role="tabpanel" aria-labelledby="pills-promotions-tab">
                            <div class="message-list-content mx-n4 px-4 message-list-scroll">
                                <ul class="message-list" id="promotions-mail-list"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection