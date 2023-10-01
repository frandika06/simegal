<?php
$auth = Auth::user();
$role = $auth->role;
$sub_role = \explode(',', $auth->sub_role);
$sub_sub_role = \explode(',', $auth->sub_sub_role);

// PEGAWAI
$ar_sub_role = ['Admin Aplikasi', 'Kasi', 'Petugas'];
?>

@if ($role == 'Admin System' || $role == 'Super Admin')
    @include('layouts.admin.menus.portal_apps.pegawai')
@elseif ($role == 'Pegawai')
    @if (count(array_intersect($sub_role, $ar_sub_role)) != 0)
        @include('layouts.admin.menus.portal_apps.pegawai')
    @else
        @include('layouts.admin.menus.portal_apps.admin_portal')
    @endif
@endif
