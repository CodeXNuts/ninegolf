<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartController extends Controller
{

    public function index()
    {

        $data = $this->getCart();
        return view('cart.index', ['crtContents' => $data['crtContents'], 'priceBox' => $data['priceBox']]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'club' => ['required', 'exists:clubs,id'],
            'fromDate' => ['required', 'date', 'date_format:m/d/Y'],
            'fromTime' => ['required'],
            'toDate' => ['required', 'date', 'date_format:m/d/Y'],
            'toTime' => ['required'],
            'days' => ['required', 'numeric'],
            'loc' => ['required', 'exists:club_addresses,id']
        ]);

        try {
            if (auth()->check()) {
                $ifItemPresent = Cart::with(['cartItems' => function ($q) use ($request) {
                    $q->where('club_id', $request->club);
                }])->where(['user_id' => auth()->id()])->first();

                if (!empty($ifItemPresent->cartItems->id) && (count($ifItemPresent->cartItems) > 0)) {
                    
                    $res = [
                        'key' => 'info',
                        'msg' => 'Item already present in your cart',
                        'cnt' => Cart::where([
                            'user_id' => auth()->id()
                        ])->count()
                    ];

                    return $res;
                } else {
                    $isCartPresentForThisUser = Cart::where(['user_id' => auth()->id()])->first();

                    if (!empty($isCartPresentForThisUser->id)) {
                        $cartDetails = $isCartPresentForThisUser;
                    } else {
                        $cartDetails = Cart::create([
                            'user_id' => auth()->id() ?? null,
                        ]);
                    }
                    if (!empty($cartDetails->id)) {

                        $insertedCartItems = $cartDetails->cartItems()->create([
                            'club_id' => $request->club,
                            'from_date' => $request->fromDate,
                            'from_time' => $request->fromTime,
                            'to_date' => $request->toDate,
                            'to_time' => $request->toTime,
                            'days' => $request->days,
                            'club_address_id' => $request->loc
                        ]);

                        if (!empty($insertedCartItems->id)) {
                            $res = [
                                'key' => 'success',
                                'msg' => 'Item has been addded into your cart',
                                'cnt' => $this->getCartCount()
                            ];
                        } else {
                            $res = [
                                'key' => 'fail',
                                'msg' => 'Item cannot be addded into your cart',
                                'cnt' => $this->getCartCount()
                            ];
                        }



                        return $res;
                    } else {
                        $res = [
                            'key' => 'fail',
                            'msg' => 'Item cannot be addded into your cart',
                            'cnt' => $this->getCartCount()
                        ];

                        return $res;
                    }
                }
            } else {

                $allCookies = Cookie::get();

                if (!empty($allCookies['auth_key'])) {

                    $guestID = $allCookies['auth_key'] ?? null;
                } else {
                    //create new
                    $guestID = Str::random(15);
                    $isCookieSet = Cookie::queue('auth_key', $guestID, (time() + (30 * 24 * 60 * 60))); 
                    if(empty($isCookieSet))
                    {
                        $res = [
                            'key' => 'fail',
                            'msg' => 'Please login to add item into cart',
                            'cnt' => $this->getCartCount()
                        ];
                    }

                }

                $ifItemPresent = Cart::with(['cartItems' => function ($q) use ($request) {
                    $q->where('club_id', $request->club);
                }])->where(['guest_id' => $guestID])->first();


                if (!empty($ifItemPresent->cartItems->id) && (count($ifItemPresent->cartItems) > 0)) {
                    
                    
                    
                    $res = [
                        'key' => 'info',
                        'msg' => 'Item already present in your cart',
                        'cnt' => $this->getCartCount()
                    ];

                    return $res;
                } else {

                    $isCartPresentForThisUser = Cart::where(['guest_id' => $guestID])->first();

                    if (!empty($isCartPresentForThisUser->id)) {
                        $cartDetails = $isCartPresentForThisUser;
                    } else {
                        $cartDetails = Cart::create([
                            'guest_id' => $guestID ?? null,
                        ]);
                    }

                    if (!empty($cartDetails->id)) {
                        $insertedCartItems = $cartDetails->cartItems()->create([
                            'club_id' => $request->club,
                            'from_date' => $request->fromDate,
                            'from_time' => $request->fromTime,
                            'to_date' => $request->toDate,
                            'to_time' => $request->toTime,
                            'days' => $request->days,
                            'club_address_id' => $request->loc
                        ]);

                        if (!empty($insertedCartItems->id)) {

                            $res = [
                                'key' => 'success',
                                'msg' => 'Item has been addded into your cart',
                                'cnt' => $this->getCartCount()
                            ];

                            return $res;
                        } else {
                            $res = [
                                'key' => 'fail',
                                'msg' => 'Item cannot be addded into your cart',
                                'cnt' => $this->getCartCount()
                            ];

                            return $res;
                        }
                    } else {
                        $res = [
                            'key' => 'fail',
                            'msg' => 'Item cannot be addded into your cart',
                            'cnt' => $this->getCartCount()
                        ];

                        return $res;
                    }
                }
            }
        } catch (Exception $e) {
            $res = [
                'key' => 'fail',
                'msg' => 'Something went wrong. Please try again',

            ];

            return $res;
        }
    }

    public function getCartCount()
    {
        $crtCnt = 0;
        if (auth()->check()) {

            $crtCnt = Cart::withCount(['cartItems'])->where([
                'user_id' => auth()->id()
            ])->first();
        } else {
            $allCookies = Cookie::get();
            if (!empty($allCookies['auth_key'])) {
                $crtCnt = Cart::withCount(['cartItems'])->where([
                    'guest_id' => $allCookies['auth_key'] ?? null
                ])->first();
            }
        }

        return ['crtCnt' => $crtCnt->cart_items_count ?? 0];
    }

    public function destroy(CartItem $cartItem)
    {
        $res = [
            'key' => 'fail',
            'msg' => 'Unable to remove item. Try again',
            'crts' => $this->getCart()
        ];

        try {
            $isRemoved = $cartItem->delete();
            // $isRemoved = true;
            if ($isRemoved) {
                $res = [
                    'key' => 'success',
                    'msg' => 'Club has been removed from the cart successfully',
                    'crts' => $this->getCart()
                ];
            }
        } catch (Exception $e) {
            $res = [
                'key' => 'success',
                'msg' => 'Cannot be removed. Try again',
                'crts' => $this->getCart()
            ];
        }

        return $res;
    }

    public function getCart()
    {
        $crtContents = [];
        if (auth()->check()) {
            $crtContents = Cart::with(['cartItems', 'cartItems.clubAddress','club'])->where([
                'user_id' => auth()->id()
            ])->first();
        } else {
            $allCookies = Cookie::get();

            if (!empty($allCookies['auth_key'])) {
                $crtContents = Cart::with(['cartItems', 'cartItems.clubAddress'])->where([
                    'guest_id' => $allCookies['auth_key']
                ])->first();
            }
        }

        $priceArr = [];

        if (!empty($crtContents)) {
            $crtContents->cartItems->filter(
                fn ($k) =>
                $k->delete = route('cartItem.remove', ['cartItem' => $k->id])
            );

            foreach ($crtContents->cartItems as $item) {
                if ($item->club->type == 'set') {
                    array_push($priceArr, [
                        'name' => Str::title($item->club->set_name),
                        'cost' => !empty($item->club->set_price) ? (number_format(floatval($item->club->set_price) * intval($item->days), 2)) : 0.00
                    ]);
                } elseif ($item->club->type == 'individual') {
                    array_push($priceArr, [
                        'name' => Str::title($item->club->clubLists[0]->name),
                        'cost' => !empty($item->club->clubLists[0]->price) ? (number_format(floatval($item->club->clubLists[0]->price) * intval($item->days), 2)) : 0.00
                    ]);
                }
            }
        }

        

        return ['crtContents' => $crtContents, 'priceBox' => $priceArr];
    }
}
