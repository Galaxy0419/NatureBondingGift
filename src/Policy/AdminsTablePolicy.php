<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\AdminsTable;
use Authorization\IdentityInterface;

/**
 * Admins policy
 */
class AdminsTablePolicy
{
    /**
     * Check if $user can view admins
     *
     * @param IdentityInterface $user
     * @param AdminsTable $admin
     * @return bool
     */
    public function canIndex(IdentityInterface $user, AdminsTable $admin): bool
    {
        return $user->role == 0;
    }

    /**
     * Check if $user can add an admin
     *
     * @param IdentityInterface $user
     * @param AdminsTable $admin
     * @return bool
     */
    public function canAdd(IdentityInterface $user, AdminsTable $admin): bool
    {
        return $user->role == 0;
    }

    /**
     * Check if $user can delete an admin
     *
     * @param IdentityInterface $user
     * @param AdminsTable $admin
     * @return bool
     */
    public function canDelete(IdentityInterface $user, AdminsTable $admin): bool
    {
        return $user->role == 0;
    }

    /**
     * Check if $user can edit an admin
     *
     * @param IdentityInterface $user
     * @param AdminsTable $admin
     * @return bool
     */
    public function canEdit(IdentityInterface $user, AdminsTable $admin): bool
    {
        return $user->role == 0;
    }
}
