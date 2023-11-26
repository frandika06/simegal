<?php
$auth = Auth::user();
$role = $auth->role;
$subSubRoleKetuaTimPelayanan = \CID::subSubRoleKetuaTimPelayanan();
?>

@if ($role == 'Admin System')
    @include('layouts.admin.menus.schedule_apps.admin_system')
@elseif ($role == 'Pegawai' || $role == 'Super Admin' || $role == 'Kepala Dinas' || $role == 'Kepala Bidang')
    @if (\CID::subRoleAdmin() == true)
        @include('layouts.admin.menus.schedule_apps.admin_aplikasi')
    @elseif (\CID::subRolePimpinan() == true)
        @include('layouts.admin.menus.schedule_apps.pimpinan')
    @elseif (\CID::subSubRoleKetuaTim() == true)
        @include('layouts.admin.menus.schedule_apps.ketua_tim')
    @elseif(\CID::subRoleOnlyPetugas())
        @include('layouts.admin.menus.schedule_apps.petugas')
    @endif
@endif
