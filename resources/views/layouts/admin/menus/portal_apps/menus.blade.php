<?php
$auth = Auth::user();
$role = $auth->role;
?>

@if ($role == 'Admin System' || $role == 'Super Admin')
    @include('layouts.admin.menus.portal_apps.pegawai')
@elseif ($role == 'Pegawai')
    @if (\CID::subRolePegawai() == true)
        @include('layouts.admin.menus.portal_apps.pegawai')
    @else
        @include('layouts.admin.menus.portal_apps.admin_portal')
    @endif
@endif
