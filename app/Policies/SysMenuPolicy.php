<?php

namespace App\Policies;

use App\Models\SysMenu;
use Dcs\Admin\Models\SysUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class SysMenuPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Dcs\Admin\Models\SysUser  $sysUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(SysUser $sysUser)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Dcs\Admin\Models\SysUser  $sysUser
     * @param  \App\Models\SysMenu  $sysMenu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(SysUser $sysUser, SysMenu $sysMenu)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Dcs\Admin\Models\SysUser  $sysUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(SysUser $sysUser)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Dcs\Admin\Models\SysUser  $sysUser
     * @param  \App\Models\SysMenu  $sysMenu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(SysUser $sysUser, SysMenu $sysMenu)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Dcs\Admin\Models\SysUser  $sysUser
     * @param  \App\Models\SysMenu  $sysMenu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(SysUser $sysUser, SysMenu $sysMenu)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Dcs\Admin\Models\SysUser  $sysUser
     * @param  \App\Models\SysMenu  $sysMenu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(SysUser $sysUser, SysMenu $sysMenu)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Dcs\Admin\Models\SysUser  $sysUser
     * @param  \App\Models\SysMenu  $sysMenu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(SysUser $sysUser, SysMenu $sysMenu)
    {
        //
    }
}
