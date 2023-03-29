<?php

namespace App\Policies;

use App\Models\SysMenuItem;
use Dcs\Admin\Models\SysUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class SysMenuItemPolicy
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
     * @param  \App\Models\SysMenuItem  $sysMenuItem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(SysUser $sysUser, SysMenuItem $sysMenuItem)
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
     * @param  \App\Models\SysMenuItem  $sysMenuItem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(SysUser $sysUser, SysMenuItem $sysMenuItem)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Dcs\Admin\Models\SysUser  $sysUser
     * @param  \App\Models\SysMenuItem  $sysMenuItem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(SysUser $sysUser, SysMenuItem $sysMenuItem)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Dcs\Admin\Models\SysUser  $sysUser
     * @param  \App\Models\SysMenuItem  $sysMenuItem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(SysUser $sysUser, SysMenuItem $sysMenuItem)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Dcs\Admin\Models\SysUser  $sysUser
     * @param  \App\Models\SysMenuItem  $sysMenuItem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(SysUser $sysUser, SysMenuItem $sysMenuItem)
    {
        //
    }
}
