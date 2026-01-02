<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::Staff;
    }

    public function view(User $user, Company $company): bool
    {
        return $this->viewAny($user) || $user->company_id === $company->getKey();
    }

    public function update(User $user, Company $company): bool
    {
        return $user->role === UserRole::Staff;
    }

    public function delete(User $user, Company $company): bool
    {
        return $this->update($user, $company);
    }
}
