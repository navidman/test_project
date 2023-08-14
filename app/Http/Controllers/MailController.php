<?php

namespace App\Http\Controllers;

use App\Mail\ToplicantMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function sendMail($email, $subject, $name, $content, $type = 'user-face')
    {
        $body = [
            'subject' => $subject,
            'name' => $name,
            'content' => $content,
        ];

        if ($type === 'user-face') {
            $body['interface'] = 'user-face';
        } else {
            $body['interface'] = 'normal-face';
        }

        if (Mail::to($email)->send(new ToplicantMail($body))) {
            return true;
        }else {
            return false;
        }
    }
}
