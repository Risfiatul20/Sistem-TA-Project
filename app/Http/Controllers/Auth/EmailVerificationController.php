<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    public function sendVerificationLink(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route($request->user()->role . '.dashboard'));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }

    public function verify(Request $request): RedirectResponse
    {
        if ($request->user()->markEmailAsVerified()) {
            return redirect()->intended(route($request->user()->role . '.dashboard').'?verified=1');
        }

        return redirect()->route($request->user()->role . '.dashboard')->with('status', 'email-verification-failed');
    }
}