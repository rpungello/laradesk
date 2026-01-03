<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Attachment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttachmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::Staff;
    }

    public function view(User $user, Attachment $attachment): bool
    {
        return $user->can('view', $attachment->comment);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Attachment $attachment): bool
    {
        return $user->role === UserRole::Staff;
    }
}
