<?php

namespace App\Policies;

use App\Models\Club;
use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClubRatingReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user, Club $club)
    {
        $orderDetails = Order::with(['orderDetails' => function ($q) use ($club) {
            $q->where(['club_id' => $club->id]);
        }])->where(['user_id' => $user->id])->get()->pluck('orderDetails');

        $isThisProductPurchased = false;

        foreach ($orderDetails as $eachOrder) {
            if ((count($eachOrder) > 0) && !empty($eachOrder)) {
                $isThisProductPurchased = true;
                break;
            }
        }

        return ($isThisProductPurchased || ($club->user_id == $user->id));
    }
}
