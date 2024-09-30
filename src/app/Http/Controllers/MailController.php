<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\NotificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class MailController extends Controller
{
    public function createNotification() {
        return view('admin.email_notification');
    }

    public function sendNotification(Request $request){
        $destination = $request->input('destination');
        $message = $request->input('message');

        if ($destination === 'user') {
            $users = User::doesntHave('roles')->get();
        } else {
            $role = Role::findByName($destination);
            $users = $role ? $role->users : collect();
        }

        foreach ($users as $user) {
            Mail::to($user->email)->send(new NotificationMail($user, $message));
        }

        return redirect()->back()->with('success', 'メールが送信されました');
    }
}
