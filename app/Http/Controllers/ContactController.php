<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function contactUs(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_number' => 'required|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Save contact submission
        Contact::create($validated);

        // Email recipients
        $toEmail = 'mahdismahi.13@gmail.com';
        $ccEmails = [
            'santsu.mehdi@gmail.com'
        ];

        // Send email
        Mail::to($toEmail)
            ->cc($ccEmails)
            ->send(new ContactFormMail(
                'Contact Form Submission: ' . $validated['subject'],
                $validated
            ));

        return response()->json([
            'success' => true,
            'message' => 'Thank you for contacting us. We will get back to you soon.',
        ]);
    }
}
