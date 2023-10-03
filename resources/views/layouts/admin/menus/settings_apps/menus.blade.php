<?php
$auth = Auth::user();
$role = $auth->role;
?>

@if ($role == 'Admin System')
    @include('layouts.admin.menus.settings_apps.admin_system')
@elseif ($role == 'Pegawai' || $role == 'Super Admin')
    @if (\CID::subRolePegawai() == true)
        @include('layouts.admin.menus.settings_apps.admin_system')
    @endif
@endif
