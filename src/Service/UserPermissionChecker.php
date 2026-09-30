<?php

namespace App\Service;

use App\Entity\User;

class UserPermissionChecker
{

    public function canManage(User $connectedUser, User $targetUser)
    {
        if($this->hasRole($connectedUser, "ROLE_SUPER_ADMIN")){
            return true;
        }

        if($this->hasRole($connectedUser, "ROLE_ADMIN")){
            return !$this->estAdminOuPlus($targetUser);
        }

        return false;
    }

    public function canDelete(User $connectedUser, User $targetUser)
    {
        if($targetUser === $connectedUser){
            return false;
        }

        return $this->canManage($connectedUser, $targetUser);
    }

    public function canSee(User $connectedUser, User $targetUser): bool
    {
        if ($targetUser === $connectedUser) {
            return true;
        }
 
        return $this->canManage($connectedUser, $targetUser);
    }

    private function hasRole(User $user, string $role)
    {
        return in_array($role, $user->getRoles(), true);
    }

    private function estAdminOuPlus(User $user)
    {
        return $this->hasRole($user, "ROLE_SUPER_ADMIN") || $this->hasRole($user, "ROLE_ADMIN");
    }
}
