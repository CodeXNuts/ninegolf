<?php

namespace App\Http\Controllers\Auth;

use App\Helper\Media;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

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
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'checkAgreement' => ['required',Rule::in('on')],
            'phone' => ['required','numeric','digits:10'],
            // 'role' => ['required','numeric', Rule::in(1,2)],
            'image'=>'required | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/jpg,image/JPG,image/webp | max:50048'

        ]);

        if ($request->hasFile('image') && ($request->file('image') instanceof UploadedFile)) {
            $fileData = $this->uploads($request->file('image'), 'user/avatar/');
        }



        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'checked_agreement' => (!empty($request->checkAgreement) && ($request->checkAgreement =='on')) ? true : false,
            'phone' => $request->phone,
            'avatar' => $fileData['filePath'] ?? null
        ]);

        event(new Registered($user));

        Auth::login($user);
        (new AuthenticatedSessionController())->updateGuestCartToUserCart();
        return redirect(RouteServiceProvider::HOME);
    }

   
}
