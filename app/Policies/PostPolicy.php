<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('editor') && $user->hasPermissionTo('View Blog')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('editor') && $user->hasPermissionTo('View Blog')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('editor') && $user->hasPermissionTo('Create Blog')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('editor') && $user->hasPermissionTo('Update Blog')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('editor') && $user->hasPermissionTo('Delete Blog')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('editor') && $user->hasPermissionTo('Delete Blog')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('editor') && $user->hasPermissionTo('Delete Blog')) {
            return true;
        } else {
            return false;
        }
    }
}
