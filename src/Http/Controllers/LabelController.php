<?php

namespace Mailstream\Quickmail\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mailstream\Quickmail\Http\Requests\LabelRequest;
use Mailstream\Quickmail\Models\Email;
use Mailstream\Quickmail\Models\EmailLabel;
use Mailstream\Quickmail\Models\Label;

class LabelController extends Controller
{
    public function storeLabels(LabelRequest $request)
    {
        $validated = $request->validated();
        Label::create([
            'name' => $validated['label'],
            'user_id' => Auth::id(),
        ]);
        return redirect()->back()->with('success', 'Label added successfully.');
    }

    public function updateLabel(LabelRequest $request, $id)
    {
        $validated = $request->validated();
        $label = Label::findOrFail($id);
        $label->update([
            'name' => $validated['label'],
        ]);

        return redirect()->back();
    }

    public function getLabels()
    {
        $labels = Label::where('user_id', Auth::id())->get();
        return view('quickmail::pages.mailbox', ['labels' => $labels]);
    }

    public function destroy($id)
    {
        $label = Label::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $label->delete();
        return redirect()->back();
    }

    public function assignLabelToEmails(Request $request)
    {

        try {

            $request->validate([
                'mail_id' => 'required|array',
                'mail_id.*' => 'exists:email_recipients,mail_id',
                'label_id' => 'required|integer|exists:labels,id',
            ]);

            $userId = auth()->id();
            $labelId = $request->label_id;

            foreach ($request->mail_id as $emailId) {

                EmailLabel::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'mail_id' => $emailId,
                        'label_id' => $labelId,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Emails labeled successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error labeling emails: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign label to emails.',
            ], 500);
        }
    }

    public function emailsByLabel($labelId)
    {
        try {
            $userId = Auth::id();
            $getUserLabels = Label::where('user_id', $userId)->get();
            
            $label = EmailLabel::where('id', $labelId)
                ->where('user_id', $userId)
                ->firstOrFail();

            $emailIds = DB::table('email_labels')
                ->where('label_id', $labelId)
                ->where('user_id', $userId)
                ->pluck('mail_id');
            $emails = Email::whereIn('id', $emailIds)->where('user_id', $userId)->get();

            return view('quickmail::pages.mailbox', [
                'emails' => $emails,
                'labels' => $getUserLabels,
                'tab' => $label->name,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to retrieve emails: ' . $e->getMessage());
        }
    }
}
