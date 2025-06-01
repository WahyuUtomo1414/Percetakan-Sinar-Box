<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OrdersPayment;
use App\Models\OrdersPeyment;
use Illuminate\Auth\Access\Response;

class OrdersPaymentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OrdersPayment $ordersPeyment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role_id === 2;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OrdersPayment $ordersPeyment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OrdersPayment $ordersPeyment): bool
    {
        // Only allow users with role_id 1 (admin) to delete
        return false;
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        // Only allow users with role_id 1 (admin) to delete any
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, OrdersPayment $ordersPeyment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, OrdersPayment $ordersPeyment): bool
    {
        return false;
    }
}
