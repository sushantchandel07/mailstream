<?php

namespace Mailstream\Quickmail\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mailstream\Quickmail\Models\Email;
use Mailstream\Quickmail\Models\EmailRecipient;
use Mailstream\Quickmail\Models\Label;

class MailService
{
    public function store(array $data)
    {

        return  Email::create([
            'mail_subject' => $data['mail_subject'],
            'mail_body' => $data['mail_body'] ?? null,
            'is_sent' => $data['is_sent'] ?? false,
            'is_draft' => $data['is_draft'] ?? true,
            'user_id' => Auth::id(),
        ]);
    }

    public function updateOrCreateEmail(array $data, $emailId = null)
    {
        return Email::updateOrCreate(
            ['id' => $emailId],
            $data
        );
    }


    public function updateEmailStatus(array $emailIds, string $action): bool
    {
        $column = null;
        $status = null;

        switch ($action) {
            case 'mark_as_read':
                $column = 'is_read';
                $status = true;
                break;
            case 'mark_as_unread':
                $column = 'is_read';
                $status = false;
                break;
            case 'mark_as_important':
                $column = 'is_important';
                $status = true;
                break;
            case 'mark_as_spam':
                $column = 'is_spam';
                $status = true;
                break;
            case 'mark_as_archive':
                $column = 'is_archived';
                $status = true;
                break;
            default:
                throw new \InvalidArgumentException('Invalid action provided.');
        }

        DB::table('email_recipients')
            ->whereIn('mail_id', $emailIds)
            ->update([$column => $status]);

        if ($action === 'mark_as_important') {
            DB::table('emails')
                ->whereIn('id', $emailIds)
                ->where('is_draft', true)
                ->update(['draft_is_important' => true]);
        }
        return true;
    }


    public function storeEmailRecipients($emailId, $recipientsData, $senderId)
    {
        $recipientTypes = ['email' => 'TO', 'cc' => 'CC', 'bcc' => 'BCC'];
        foreach ($recipientTypes as $field => $type) {
            if (!empty($recipientsData[$field])) {
                $recipientEmail = $recipientsData[$field];
                $recipientUser = User::where('email', $recipientEmail)->first();
                if ($recipientUser) {
                    $data =  EmailRecipient::create([
                        'mail_id' => $emailId,
                        'sender_id' => $senderId,
                        'recipients_id' => $recipientUser->id,
                        'recipient_type' => $type,
                        'is_read' => false,
                        'is_starred' => false,
                        'is_trashed' => false,
                        'is_archived' => false,
                        'is_important' => false,
                    ]);
                }
            }
        }
    }

    public function getUserLabels($userId)
    {
        return Label::where('user_id', $userId)->get();
    }


    public function getEmailsByTab($userId, $tab)
    {
        $baseQuery = Email::select(
            'emails.*',
            'sender.name as sender_name',
            'recipient.name as recipient_name',
            'email_recipients.is_starred',
            'email_recipients.is_important',
            'email_recipients.is_trashed',
            'email_recipients.is_read',
            'email_recipients.id as recipient_id'
        )
            ->leftJoin('email_recipients', 'emails.id', '=', 'email_recipients.mail_id')
            ->leftJoin('users as sender', 'email_recipients.sender_id', '=', 'sender.id')
            ->leftJoin('users as recipient', 'email_recipients.recipients_id', '=', 'recipient.id');

        switch ($tab) {
            case 'inbox':
                $baseQuery->where('email_recipients.recipients_id', $userId)
                    ->where('email_recipients.is_trashed', false);
                break;

            case 'sent':
                $baseQuery->where('emails.is_sent', true)
                    ->where('email_recipients.sender_id', $userId)
                    ->where('email_recipients.is_trashed', false);
                break;

            case 'draft':
                $baseQuery->where('emails.user_id', $userId)
                    ->where('emails.is_draft', true);
                break;

            case 'starred':
                $baseQuery->where(function ($query) use ($userId) {
                    $query->where('email_recipients.recipients_id', $userId)
                        ->where('email_recipients.is_trashed', false)
                        ->where('email_recipients.is_starred', true);
                })->orWhere(function ($query) use ($userId) {
                    $query->where('emails.user_id', $userId)
                        ->where('emails.is_draft', true)
                        ->where('emails.draft_is_starred', true);
                });
                break;

            case 'important':
                $baseQuery->where('email_recipients.recipients_id', $userId)
                    ->where('email_recipients.is_important', true)
                    ->where('email_recipients.is_trashed', false);
                break;

            case 'trash':
                $baseQuery->where('email_recipients.recipients_id', $userId)
                    ->where('email_recipients.is_trashed', true);
                break;
            case 'spam':
                $baseQuery->where('email_recipients.recipients_id', $userId)
                    ->where('email_recipients.is_spam', true)
                    ->where('email_recipients.is_trashed', false);
                break;
            case 'archive':
                $baseQuery->where('email_recipients.recipients_id', $userId)
                    ->where('email_recipients.is_archived', true)
                    ->where('email_recipients.is_trashed', false);
                break;
            case 'all':
            default:
                $baseQuery->where(function ($query) use ($userId) {
                    $query->where('emails.user_id', $userId)
                        ->orWhere('email_recipients.recipients_id', $userId);
                })->where(function ($query) {
                    $query->where('email_recipients.is_trashed', false)
                        ->orWhereNull('email_recipients.is_trashed');
                });
                break;
        }

        return $baseQuery->orderBy('emails.created_at', 'desc')->get();
    }

    public function getLabelEmails($userId)
    {
        return Email::Select('emails.*')
            ->leftjoin('emails', ' emails.id', "=", "email_labels.mail_id")
            ->where('email_labels.user_id', $userId)
            ->orderBy('emails.created_at', ' desc')
            ->get();
    }
}
