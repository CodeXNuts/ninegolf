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

        return redirect()->intended('/user/profile');
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

    public function updateGuestCartToUserCart()
    {
        $allCookies = Cookie::get();

        if (!empty($allCookies['auth_key'])) {
            $crtContents = Cart::with(['cartItems'])->where([
                'guest_id' => $allCookies['auth_key']
            ])->first();

            if (!empty($crtContents)) {
                try {

                    $isCartPresentForThisUser = Cart::where(['user_id' => auth('web')->id()])->first();

                    if (!empty($isCartPresentForThisUser->id)) {
                        $cartDetails = $isCartPresentForThisUser;
                    } else {
                        $cartDetails = Cart::create([
                            'user_id' => auth('web')->id() ?? null,
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
