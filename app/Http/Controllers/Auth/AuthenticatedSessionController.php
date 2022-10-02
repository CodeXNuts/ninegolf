<?php

namespace App\Http\Controllers\Auth;

use App\Helper\Media;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Cart;
use App\Models\User;
use App\Models\UserStripeConnectedAccount;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AuthenticatedSessionController extends Controller
{
    use Media;
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {

        $request->authenticate();

        $request->session()->regenerate();

        $this->updateGuestCartToUserCart();

        if (!empty($request->req) && ($request->req == 'return')) {
            return [
                'key' => 'success',
                'msg' => 'You are successfully logged in'
            ];
        }

        return redirect()->intended('/profile');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function view()
    {
        $products = (new ProductController)->index();
        $stripeAccountInfo = UserStripeConnectedAccount::where(['user_id'=>auth()->id(),'is_active'=>true])->first();
        // dd($stripeAccountInfo);
        return view('profile', ['products' => $products,'stripeAccountInfo'=>$stripeAccountInfo]);
    }

    public function update(Request $request, User $user)
    {

        $this->validate($request, [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id,],
            'location' => ['required', 'max:255'],
            'phone' => ['required', 'numeric', 'digits:10'],
            // 'role' => ['required','numeric', Rule::in(1,2)],
            'editImage' => 'nullable | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/jpg,image/JPG,image/webp | max:50048'
        ]);


        try {
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->email = $request->email;
            $user->location = $request->location;
            $user->phone = $request->phone;

            if ($request->hasFile('editImage') && ($request->file('editImage') instanceof UploadedFile)) {
                $fileData = $this->uploads($request->file('editImage'), 'user/avatar/');

                if (!empty($fileData['filePath'])) {
                    if (Storage::exists('public/' . substr($user->avatar, strpos($user->avatar, '/') + 1))) {
                        Storage::delete('public/' . substr($user->avatar, strpos($user->avatar, '/') + 1));
                    }
                    $user->avatar = $fileData['filePath'] ?? null;
                }
            }

            $isUpdated = $user->save();

            if ($isUpdated) {
                $response = [
                    'key' => 'success',
                    'message' => 'Your profile has been updated successfully!!'
                ];
            } else {
                $response = [
                    'key' => 'fail',
                    'message' => 'Your profile could not be updated'
                ];
            }
        } catch (Exception $e) {
            $response = [
                'key' => 'fail',
                'message' => 'Your profile could not be updated'
            ];
        }


        return redirect()->route('profile')->with($response['key'], $response['message']);
    }

    public function updateGuestCartToUserCart()
    {
        $allCookies = Cookie::get();

        if (!empty($allCookies['auth_key'])) {
            $crtContents = Cart::with(['cartItems'])->where([
                'guest_id' => $allCookies['auth_key']
            ])->first();

            if (!empty($crtContents)) {
                try {

                    $isCartPresentForThisUser = Cart::where(['user_id' => auth()->id()])->first();

                    if (!empty($isCartPresentForThisUser->id)) {
                        $cartDetails = $isCartPresentForThisUser;
                    } else {
                        $cartDetails = Cart::create([
                            'user_id' => auth()->id() ?? null,
                        ]);
                    }

                    if (!empty($cartDetails->id)) {
                        foreach ($crtContents->cartItems as $item) {
                            $item->cart_id = $cartDetails->id;
                            $item->save();
                        }
                    }
                } catch (Exception $e) {
                    //throw $th;
                }
            }
        }
    }
}
