<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mailstream\Quickmail\Http\Controllers\LabelController;
use Mailstream\Quickmail\Http\Controllers\MailController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/mail/{tab}', [MailController::class, 'mailsByTab'])->name('mail.tab');
    Route::post('/store', [MailController::class, 'emailStore'])->name('mail.store');
    Route::post('/mail/draft', [MailController::class, 'saveOrSend'])->name('mail.draft');
    Route::post('/emails/{id}/toggle-star', [MailController::class, 'toggleStar'])->name('emails.toggle-star');
    Route::post('/trash-email', [MailController::class, 'trashStatus'])->name('emails.trash');
    Route::post('/mark-as-read/{emailRecipientId}', [MailController::class, 'markAsRead'])->name('mark.as.read');
    Route::post('/emails/action', [MailController::class, 'handleEmailAction'])->name('emails.action');
});


Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/labels', [LabelController::class, 'storeLabels'])->name('quickmail.labels');
    Route::put('/labels/{id}', [LabelController::class, 'updateLabel'])->name('quickmail.labels.update');
    Route::delete('/labels/{id}', [LabelController::class, 'destroy'])->name('quickmail.labels.destroy');
    Route::post('/emails/assign-label', [LabelController::class, 'assignLabelToEmails']);
    Route::get('labels/{id}/emails', [LabelController::class, 'emailsByLabel'])
        ->name('quickmail.labels.emails');
});
