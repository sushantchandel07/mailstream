<?php

namespace Mailstream\Quickmail\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
            default:
                throw new \InvalidArgumentException('Invalid action provided.');
        }

        Log::info('Updating email status', [
            'column' => $column,
            'status' => $status,
            'email_ids' => $emailIds,
        ]);

        return DB::table('email_recipients')
            ->whereIn('mail_id', $emailIds)
            ->update([$column => $status]);
            
    }

    public function updateOrCreateEmail(array $data, $emailId = null)
    {
        return Email::updateOrCreate(
            ['id' => $emailId],
            $data
        );
    }
    //
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

    public function getAllEmails($userId)
    {
        return Email::Select('emails.*', 'email_recipients.is_starred')
            ->leftjoin('email_recipients', 'emails.id', '=', 'email_recipients.mail_id')
            ->where('emails.user_id', $userId)
            ->orderBy('emails.created_at', 'desc')
            ->get();
    }



    public function getInboxEmails($userId)
    {
        return Email::select(
            'emails.*',
            'users.name as recipient_name',
            'email_recipients.is_read',
            'email_recipients.id as recipient_id',
            'email_recipients.is_starred'
        )
            ->join('email_recipients', 'emails.id', '=', 'email_recipients.mail_id')
            ->join('users', 'email_recipients.sender_id', '=', 'users.id')
            ->where('email_recipients.recipients_id', $userId)
            ->where('email_recipients.is_trashed', false) 
            ->orderBy('emails.created_at', 'desc')
            ->get();
    }


    public function getSentEmails($userId)
    {
        return Email::select(
            'emails.*',
            'sender.name as sender_name',
            'recipient.name as recipient_name',
            'email_recipients.is_read',
            'email_recipients.recipients_id as recipient_id',
            'email_recipients.is_starred'
        )
            ->leftJoin('email_recipients', 'emails.id', '=', 'email_recipients.mail_id')
            ->leftJoin('users as sender', 'email_recipients.sender_id', '=', 'sender.id')
            ->leftJoin('users as recipient', 'email_recipients.recipients_id', '=', 'recipient.id')
            ->where('email_recipients.sender_id', $userId)
            ->where('email_recipients.is_trashed', false)
            ->orderBy('emails.created_at', 'desc')
            ->get();
    }

 
    public function getDraftEmails($userId)
    {
        return Email::select(
            'emails.*',
            'users.name as sender_name'
        )
            ->leftJoin('users', 'emails.user_id', '=', 'users.id')
            ->where('emails.user_id', $userId)
            ->where('emails.is_draft', true)
            ->orderBy('emails.created_at', 'desc')
            ->get();
    }

    public function getStarredEmails($userId)
    {
        return Email::select(
            'emails.*',
            'email_recipients.is_starred',
            'email_recipients.id as recipient_id'
        )
            ->leftJoin('email_recipients', 'email_recipients.mail_id', '=', 'emails.id' )
            ->where(function ($query) use ($userId) {
                $query->where('email_recipients.recipients_id', $userId)
                ->where('email_recipients.is_trashed', false)
                    ->where('email_recipients.is_starred', true);
            })
            ->orWhere(function ($query) use ($userId) {
                $query->where('emails.draft_is_starred', true)
                    ->where('emails.user_id', $userId)
                    ->where('emails.is_draft', true);
            })
            ->orderBy('emails.created_at', 'desc')
            ->get();
    }


    public function getImportantEmails($userId)
    {
        return EmailRecipient::select(
                'emails.*',
                'email_recipients.is_important',
                'email_recipients.id as recipient_id'
            )
            ->join('emails', 'email_recipients.mail_id', '=', 'emails.id')
            ->where('email_recipients.recipients_id', $userId)
            ->where('email_recipients.is_important', true)
            ->orderBy('emails.created_at', 'desc')
            ->get();
    }

    public function getLabelEmails($userId)
    {
        return Email::Select('emails.*')
            ->leftjoin('emails', ' emails.id', "=", "email_labels.mail_id")
            ->where('email_labels.user_id', $userId)
            ->orderBy('emails.created_at', ' desc')
            ->get();
    }

    public function getTrashEmails($userId)
    {
        return Email::select(
            'emails.*',
            'email_recipients.is_trashed',
            'email_recipients.id as recipient_id'
        )
            ->leftJoin('email_recipients', 'emails.id', '=', 'email_recipients.mail_id')
            ->where('email_recipients.recipients_id', $userId)
            ->where('email_recipients.is_trashed', true)
            ->orderBy('emails.created_at', 'desc')
            ->get();
    }
}
