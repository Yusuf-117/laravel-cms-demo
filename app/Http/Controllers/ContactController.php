<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        Mail::raw(
            "Name: {$data['name']}\n"
            . "Email: {$data['email']}\n\n"
            . $data['message'],
            function ($mail) use ($data) {
                $mail->to(config('mail.from.address'))
                    ->subject('Portfolio Contact Form')
                    ->replyTo($data['email'], $data['name']);
            }
        );

        return response()->json([
            'message' => 'Message sent successfully.',
        ]);
    }
}
