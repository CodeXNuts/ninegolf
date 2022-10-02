<?php

namespace App\Http\Controllers\Administrator\Auth;

use App\Helper\Media;
use App\Http\Controllers\Controller;
use App\Models\Administrator;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class RegisteredUserController extends Controller
{
    use Media;
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('administrator.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:administrators',
            'password' => 'required|string|confirmed|min:8',
            'image'=>'required | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/jpg,image/JPG,image/webp | max:50048',
            'phone' => 'required',
            'address' => 'required',
            'zip' => 'required',
            'country' => 'required'
        ]);

        if ($request->hasFile('image') && ($request->file('image') instanceof UploadedFile)) {
           
                $fileData = $this->uploads($request->file('image'), 'admin/avatar/');
                
        }
        Auth::guard('administrator')->login($administrator = Administrator::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $fileData['filePath'] ?? null,
            'phone' => $request->phone,
            'address' => $request->email,
            'country'=>$request->country,
            'zip' => $request->zip

        ]));

        VerifyEmail::createUrlUsing(function ($notifiable) {
            return URL::temporarySignedRoute(
                'administrator.verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );
        });

        event(new Registered($administrator));

        return redirect(route('administrator.dashboard'));
    }
}
