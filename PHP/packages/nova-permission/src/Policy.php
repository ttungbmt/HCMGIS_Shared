<?php

namespace Vyuldashev\NovaPermission;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public static $key = null;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin() || $user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission([
            static::$key . '.create',
            static::$key . '.create-own',
        ]);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function delete(User $user, $model)
    {
        if ($user->hasPermissionTo(static::$key . '.delete')) {
            return true;
        }

        if ($user->hasPermissionTo(static::$key . '.delete-own')) {
            return $user->id == $model->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function forceDelete(User $user, $model)
    {
        if ($user->hasPermissionTo(static::$key . 'force-delete')) {
            return true;
        }

        if ($user->hasPermissionTo(static::$key . 'force-delete-own')) {
            return $user->id == $model->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function restore(User $user, $model)
    {
        if ($user->hasPermissionTo(static::$key . '.restore')) {
            return true;
        }

        if ($user->hasPermissionTo(static::$key . 'restore-own')) {
            return $user->id == $model->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function update(User $user, $model)
    {
        if ($user->hasPermissionTo(static::$key . '.update')) {
            return true;
        }

        if ($user->hasPermissionTo(static::$key . '.update-own')) {
            return $user->id == $model->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function view(User $user, $model)
    {
        if ($user->hasPermissionTo(static::$key . '.view')) {
            return true;
        }

        if ($user->hasPermissionTo(static::$key . 'view-own')) {
            return $user->id == $model->user_id;
        }

        return false;
    }

    /**
     * @param User $user
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo(static::$key . '.view');
    }
}
