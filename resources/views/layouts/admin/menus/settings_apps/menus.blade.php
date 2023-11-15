<?php
$auth = Auth::user();
$role = $auth->role;
?>

@if ($role == 'Admin System')
    @include('layouts.admin.menus.settings_apps.admin_system')
@elseif ($role == 'Super Admin' || $role == 'Pegawai' || $role == 'Kepala Dinas' || $role == 'Kepala Bidang')
    @if (\CID::subRolePegawai() == true)
        @include('layouts.admin.menus.settings_apps.pegawai')
    @endif
@endif
