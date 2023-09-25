<?php
$auth = Auth::user();
$role = $auth->role;
$sub_role = $auth->sub_role;
$sub_sub_role = $auth->sub_sub_role;
?>

@if ($role == 'Admin System' || $role == 'Super Admin')
    @include('layouts.admin.menus.portal_apps.pegawai')
@elseif ($role == 'Pegawai')
    @if ($sub_role == 'Admin Portal')
        @include('layouts.admin.menus.portal_apps.admin_portal')
    @else
        @include('layouts.admin.menus.portal_apps.pegawai')
    @endif
@endif
