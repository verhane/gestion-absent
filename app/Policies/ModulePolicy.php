<?php

namespace App\Policies;

use App\Models\User;
use Dcs\Admin\Models\SysUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModulePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // user can add module
    public function add(SysUser $user)
    {
        return $user->hasPermission('module.add');
    }


}
