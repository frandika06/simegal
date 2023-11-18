<?php
$auth = Auth::user();
$role = $auth->role;
?>

@if ($role == 'Admin System')
    @include('layouts.admin.menus.schedule_apps.admin_system')
@elseif ($role == 'Pegawai' || $role == 'Super Admin')
    @if (\CID::subRoleAdmin() == true)
        @include('layouts.admin.menus.schedule_apps.admin_aplikasi')
    @elseif(\CID::subRoleOnlyPetugas())
        @include('layouts.admin.menus.schedule_apps.petugas')
    @endif
@endif
