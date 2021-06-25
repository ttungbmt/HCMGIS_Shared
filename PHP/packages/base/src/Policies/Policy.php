<?php

namespace Larabase\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public static $key;

    public function before(User $user, $ability)
    {
        if ($user->isSuperAdmin()) return true;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo(static::$key . '.view-any');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param $model
     * @return mixed
     */
    public function view(User $user, $model)
    {
        if ($user->hasPermissionTo(static::$key . '.view'))
            return true;

        if ($user->hasPermissionTo(static::$key . '.view-own'))
            return $user->id == $model->user_id;

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission([
            static::$key . '.manage',
            static::$key . '.manage-own',
            static::$key . '.create',
            static::$key . '.create-own',
        ]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @return mixed
     */
    public function update(User $user, $model)
    {
        if ($user->hasAnyPermission([static::$key . '.manage', static::$key . '.update']))
            return true;

        if ($user->hasAnyPermission([static::$key . '.manage-own', static::$key . '.update-own']))
            return $user->id == $model->user_id;

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @return mixed
     */
    public function delete(User $user, $model)
    {
        if ($user->hasAnyPermission([static::$key . '.manage', static::$key . '.delete']))
            return true;

        if ($user->hasAnyPermission([static::$key . '.manage-own', static::$key . '.delete-own']))
            return $user->id == $model->user_id;

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @return mixed
     */
    public function forceDelete(User $user, $model)
    {
        if ($user->hasPermissionTo(static::$key . '.force-delete'))
            return true;

        if ($user->hasAllPermissions([static::$key . '.manage-own', static::$key . '.force-delete']))
            return $user->id == $model->user_id;

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @return mixed
     */
    public function restore(User $user, $model)
    {
        if ($user->hasPermissionTo(static::$key . '.restore'))
            return true;

        if ($user->hasAllPermissions([static::$key . '.manage-own', static::$key . '.restore']))
            return $user->id == $model->user_id;

        return false;
    }
}