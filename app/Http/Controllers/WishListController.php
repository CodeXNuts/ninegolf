<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\WishList;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class WishListController extends Controller
{
    public function manageWislistCRUD(Request $request)
    {
        $this->validate($request, [
            'club' => 'required |exists:clubs,id| numeric'
        ]);

        if (auth()->check()) {

            $ifPresent = WishList::where([
                'user_id' => auth()->id(),
                'club_id' => $request->club
            ])->first();

            if (!empty($ifPresent->id)) {
                $isDeleted = $ifPresent->delete();
                if ($isDeleted) {
                    $res = [
                        'key' => 'success',
                        'msg' => 'Item has been removed from your wishlist',
                        'type' => 0 // removed
                    ];
                } else {
                    $res = [
                        'key' => 'fail',
                        'msg' => 'Woops!! Something went wrong'
                    ];
                }
            } else {
                try {
                    $insertedWishList = WishList::create([
                        'user_id' => auth()->id(),
                        'club_id' => $request->club
                    ]);
    
                    if (!empty($insertedWishList->id)) {
                        $res = [
                            'key' => 'success',
                            'msg' => 'Item has been added to your wishlist successfully',
                            'type' => 1 // added
                        ];
                    } else {
                        $res = [
                            'key' => 'fail',
                            'msg' => 'Woops!! Something went wrong'
                        ];
                    }
                } catch (Exception $e) {
                    $res = [
                        'key' => 'fail',
                        'msg' => 'Woops!! Something went wrong'
                    ];
                }
            }
        } else {
            $allCookies = Cookie::get();

            if (!empty($allCookies['auth_key'])) {

                $guestID = $allCookies['auth_key'] ?? null;
            } else {
                //create new
                $guestID = Str::random(15);
            }


            try {

                $ifPresent = WishList::where([
                    'club_id' => $guestID,
                    'club_id' => $request->club
                ])->first();

                if (!empty($ifPresent->id)) {
                    $isDeleted = $ifPresent->delete();
                    if ($isDeleted) {
                        $res = [
                            'key' => 'success',
                            'msg' => 'Item has been removed from your wishlist',
                            'type' => 0 // removed
                        ];
                    } else {
                        $res = [
                            'key' => 'fail',
                            'msg' => 'Woops!! Something went wrong'
                        ];
                    }
                } else {
                    $insertedWishList = WishList::create([
                        'guest_id' => $guestID,
                        'club_id' => $request->club
                    ]);

                    if (!empty($insertedWishList->id) && empty($allCookies['auth_key'])) {
                        Cookie::queue('auth_key', $guestID, (time() + (30 * 24 * 60 * 60))); // wishlist for guest time -30days
                    }

                    if (!empty($insertedWishList->id)) {
                        $res = [
                            'key' => 'success',
                            'msg' => 'Item has been added to your wishlist successfully',
                            'type' => 1 // added
                        ];
                    } else {
                        $res = [
                            'key' => 'fail',
                            'msg' => 'Woops!! Something went wrong'
                        ];
                    }
                }
            } catch (Exception $e) {

                $res = [
                    'key' => 'fail',
                    'msg' => 'Woops!! Something went wrong'
                ];
            }


        }

        return $res;
    }
}
