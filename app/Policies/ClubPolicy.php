<?php

namespace App\Policies;

use App\Models\Club;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClubPolicy
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
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Club $club)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        
        $user = User::with(['userStripeConnectedAccount'=>function($q){
            $q->where('is_completed',true);
            $q->where('is_active',true);
        }])->find(request()->user('web')->id);

        
        
        if(auth()->check())
        {
            if(!empty($user->userStripeConnectedAccount->is_completed) && !empty($user->userStripeConnectedAccount->is_active))
            {
                return true;
            }
            else
            {
                return $this->deny('Unauthorised! You have not activated your payment account yet. Set up payment account first.');
            }
            
        }
        return (!empty($user->userStripeConnectedAccount->is_completed) && !empty($user->userStripeConnectedAccount->is_active) && (auth()->check()));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Club $club)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Club $club)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Club $club)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Club $club)
    {
        //
    }
}
