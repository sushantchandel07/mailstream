<?php

namespace Mailstream\Quickmail\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mailstream\Quickmail\Http\Requests\EmailRequest;
use Mailstream\Quickmail\Models\Email;
use Mailstream\Quickmail\Models\EmailLabel;
use Mailstream\Quickmail\Models\EmailRecipient;
use Mailstream\Quickmail\Services\MailService;

class MailController extends Controller
{
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function emailStore(EmailRequest $request)
    {
        try {

            $validated = $request->validated();
            $validated['is_sent'] = true;
            $validated['is_draft'] = false;
            $email = $this->mailService->updateOrCreateEmail($validated, $request->get('email_id'));

            $this->mailService->storeEmailRecipients($email->id, $request->only(['email', 'cc', 'bcc']), Auth::id());
            return redirect()->back()->with('success', 'Email sent successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to send email: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function saveOrSend(Request $request)
    {
        try {

            $data = $request->only(['email', 'mail_subject', 'mail_body']);
            $data['is_draft'] = true;
            $data['is_sent'] = false;
            $data['user_id'] = Auth::id();
            
            $email = $this->mailService->updateOrCreateEmail($data, $request->get('email_id'));

            return response()->json(['message' => 'Draft saved', 'email_id' => $email->id]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to send email: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function handleEmailAction(Request $request)
    {
        try {
            $request->validate([
                'email_ids' => 'required|array',
                'email_ids.*' => 'integer',
                'action' => 'required|string',
            ]);
            $emailIds = $request->input('email_ids');
            $action = $request->input('action');

            $success = $this->mailService->updateEmailStatus($emailIds, $action);
            if ($success) {
                return response()->json(['message' => 'Emails updated successfully.'], 200);
            }
        } catch (\Exception $e) {
            Log::error('Error updating email status', [
                'error_message' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }

    public function allMails()
    {
        try {
            $userId = Auth::id();
            $labels = $this->mailService->getUserLabels($userId);
            $allEmails = $this->mailService->getAllEmails($userId);

            return view('quickmail::pages.mailbox', [
                'emails' => $allEmails,
                'labels' => $labels,
                'tab' => 'all',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to send email: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function inboxMail()
    {
        try {
            $userId = Auth::id();
            $labels = $this->mailService->getUserLabels($userId);
            $inboxEmails = $this->mailService->getInboxEmails($userId);

            return view('quickmail::pages.mailbox', [
                'emails' => $inboxEmails,
                'labels' => $labels,
                'tab' => 'inbox',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to send email: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function sentMails()
    {
        try {
            $userId = Auth::id();
            $labels = $this->mailService->getUserLabels($userId);
            $sentEmails = $this->mailService->getSentEmails($userId);

            return view('quickmail::pages.mailbox', [
                'emails' => $sentEmails,
                'labels' => $labels,
                'tab' => 'sent',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to send email: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function draftsMails()
    {
        try {
            $userId = Auth::id();
            $labels = $this->mailService->getUserLabels($userId);
            $draftEmails = $this->mailService->getDraftEmails($userId);
            return view('quickmail::pages.mailbox', [
                'emails' => $draftEmails,
                'labels' => $labels,
                'tab' => 'draft',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to send email: ' . $e->getMessage())
                ->withInput();
        }
    }
 
   

    


    public function toggleStar(Request $request, $id)
    {
        try {
            $email = Email::find($id);

            if (!$email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email not found',
                ], 404);
            }

            if ($email->is_draft) {
                $email->draft_is_starred = $request->input('is_starred');
                $email->save();

                return response()->json([
                    'success' => true,
                    'is_starred' => $email->draft_is_starred,
                    'message' => 'Draft star status updated successfully',
                ]);
            }

            $emailRecipient = EmailRecipient::where('mail_id', $id)->first();

            if (!$emailRecipient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email recipient not found',
                ], 404);
            }

            $emailRecipient->is_starred = $request->input('is_starred');
            $emailRecipient->save();

            return response()->json([
                'success' => true,
                'is_starred' => $emailRecipient->is_starred,
                'message' => 'Star status updated successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling star status: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update star status',
            ], 500);
        }
    }


    public function starredMails()
    {
        try {
            $userId = Auth::id();

            $labels = $this->mailService->getUserLabels($userId);
            $starredEmails = $this->mailService->getStarredEmails($userId);

            return view('quickmail::pages.mailbox', [
                'emails' => $starredEmails,
                'labels' => $labels,
                'tab' => 'starred',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to fetch starred emails: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function importantMails()
    {
        try {
            $userId = Auth::id();

            $labels = $this->mailService->getUserLabels($userId);

            $importantEmails = $this->mailService->getImportantEmails($userId);
            return view('quickmail::pages.mailbox', [
                'emails' => $importantEmails,
                'labels' => $labels,
                'tab' => 'important',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to fetch important emails: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function LabelEmails()
    {
        try {
            $userId = Auth::id();
            $labels = $this->mailService->getUserLabels($userId);
            return view('quickmail::pages.mailbox', [
                'labels' => $labels,
                'tab' => 'labels',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to fetch important emails: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function trashStatus(Request $request)
    {
        
        try {
            $emailId = $request->input('email_id');
            
            $email = EmailRecipient::where('mail_id' ,$emailId )->first();
            $email->is_trashed = true;
            $email->save();
    
            return redirect()->route('emails.index')->with('success', 'Email moved to trash.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to move email to trash: ' . $e->getMessage());
        }
    }
     
    public function trashEmails()
    {
        try {
            $userId = Auth::id();

            $labels = $this->mailService->getUserLabels($userId);
            $trashedEmails = $this->mailService->getTrashEmails(Auth::id());


            return view('quickmail::pages.mailbox', [
                'emails' => $trashedEmails,
                'labels' => $labels,
                'tab' => 'trash',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to fetch starred emails: ' . $e->getMessage())
                ->withInput();
        }
    }

 
}
