<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mailstream\Quickmail\Http\Controllers\LabelController;
use Mailstream\Quickmail\Http\Controllers\MailController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/inbox', [MailController::class, 'inboxMail'])->name('mail.inbox');
    Route::post('/store' , [MailController::class , 'emailStore'])->name('mail.store');
    Route::get('/mail/all', [MailController::class, 'allMails'])->name('mail.all');
    Route::get('/mail/inbox', [MailController::class, 'inboxMail'])->name('mail.inbox');
    Route::get('/mail/sent', [MailController::class, 'sentMails'])->name('mail.sent');
    Route::post('/mail/draft', [MailController::class, 'saveOrSend'])->name('mail.draft');
    Route::get('/mail/draft', [MailController::class, 'draftsMails'])->name('mail.drafts');
    Route::post('/emails/{id}/toggle-star', [MailController::class, 'toggleStar'])->name('emails.toggle-star');
    Route::get('/mail/starred', [MailController::class, 'starredMails'])->name('mail.starred');
    Route::post('/trash-email', [MailController::class, 'trashStatus'])->name('emails.trash');
    Route::get('/mail/trash', [MailController::class, 'trashEmails'])->name('mail.trash');
    Route::post('/mark-as-read/{emailRecipientId}', [MailController::class, 'markAsRead'])->name('mark.as.read');
    Route::post('/emails/mark-important', [mailController::class, 'markAsImportant']);
    Route::get('/emails/important', [MailController::class, 'importantMails'])->name('mail.important');
    Route::post('/emails/mark-all-unread', [MailController::class, 'markAllUnread']);
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/labels' , [LabelController::class, 'storeLabels'])->name('quickmail.labels');
    Route::put('/labels/{id}', [LabelController::class, 'updateLabel'])->name('quickmail.labels.update');
    Route::delete('/labels/{id}', [LabelController::class, 'destroy'])->name('quickmail.labels.destroy');
    Route::post('/emails/assign-label', [LabelController::class, 'assignLabelToEmails']);
    Route::get('labels/{id}/emails', [LabelController::class, 'emailsByLabel'])
    ->name('quickmail.labels.emails');
});

