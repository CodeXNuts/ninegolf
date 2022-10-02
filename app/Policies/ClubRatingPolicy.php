<?php

namespace App\Policies;

use App\Models\Club;
use App\Models\ClubRating;
use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClubRatingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClubRating  $clubRating
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ClubRating $clubRating)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
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

        return $isThisProductPurchased;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClubRating  $clubRating
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ClubRating $clubRating)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClubRating  $clubRating
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ClubRating $clubRating)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClubRating  $clubRating
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ClubRating $clubRating)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClubRating  $clubRating
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ClubRating $clubRating)
    {
        //
    }
}
