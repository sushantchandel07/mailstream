(function () {
	("use strict");
    document.addEventListener('DOMContentLoaded', function() {
        const emailSubjects = document.querySelectorAll('.email-subject');
        
        emailSubjects.forEach(subject => {
            subject.addEventListener('click', function(e) {
                const emailRecipientId = this.getAttribute('data-email-recipient-id');
                
                fetch(`/mark-as-read/${emailRecipientId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Change styling
                        const parentLi = this.closest('li');
                        parentLi.classList.remove('unread-email');
                        parentLi.classList.add('read-email');
                        
                        // Remove bold formatting
                        const boldElement = this.querySelector('b');
                        if (boldElement) {
                            const textContent = boldElement.textContent;
                            this.innerHTML = textContent;
                        }
                    }
                })
                
                const markAllUnreadBtn = document.querySelector('a[href="#"][id="mark-all-unread"]');
                if (markAllUnreadBtn) {
                    markAllUnreadBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        fetch('/mark-all-unread', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Select all email list items
                                const emailListItems = document.querySelectorAll('.message-list li');
                                
                                emailListItems.forEach(item => {
                                    // Remove read email class
                                    item.classList.remove('read-email');
                                    // Add unread email class
                                    item.classList.add('unread-email');
                                    
                                    // Make subject bold
                                    const emailSubject = item.querySelector('.email-subject');
                                    if (emailSubject) {
                                        const subjectText = emailSubject.textContent;
                                        emailSubject.innerHTML = `<b>${subjectText}</b>`;
                                    }
                                });

                                // Update unread conversations alert
                                const unreadAlert = document.getElementById('unreadConversations');
                                if (unreadAlert) {
                                    unreadAlert.textContent = `${emailListItems.length} Unread Conversations`;
                                    unreadAlert.classList.remove('d-none');
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error marking all emails as unread:', error);
                        });
                    });
                }
            });
        });
    });

});