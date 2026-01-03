<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Enums\Visibility;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Comment $comment): bool
    {
        return $user->role === UserRole::Staff || $user->getKey() === $comment->ticket->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Comment $comment): bool
    {
        return $user->role === UserRole::Staff;
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $this->update($user, $comment) && $comment->visibility !== Visibility::Public;
    }
}
