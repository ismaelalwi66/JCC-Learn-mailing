<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send()
    {
        $user = User::find(1);
        $url = URL::temporarySignedRoute(
            'welcome',
            now()->addMinutes(2),
            [
                'user' => $user->id,
                'hash' => sha1($user->email)
            ]
        );

        Mail::to('ismaelalwi66@gmail.com')->queue(new WelcomeMail($user, $url));
        // $url = URL::temporarySignedRoute(
        //     'verify',
        //     Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
        //     [
        //         'id' => $notifiable->getKey(), get id user
        //         'hash' => sha1($notifiable->getEmailForVerification()), get email user
        //     ]
        // );
        //you can add 'verification' => ['expire' => 525600,], in config/auth to change timeout
        return new WelcomeMail($user, $url);
    }

    public function verif(Request $request)
    {
        $user = User::find(1);

        if (!$request->hasValidSignature()) {
            echo "Tidak Valid";
        } else {
            if (!hash_equals(
                (string)$user->id,
                (string)$request->user
            )) {
                return "Tidak cocok";
            }
            if (!hash_equals(
                sha1($user->email),
                (string)$request->hash
            )) {
                return "Tidak cocok";
            }
            return "cocok";
        }
    }
}
