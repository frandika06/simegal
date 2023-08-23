<?php
$auth = Auth::user();
$role = $auth->role;
$sub_role = $auth->sub_role;
$sub_sub_role = $auth->sub_sub_role;
?>

@if ($role == 'Admin System' || $role == 'Super Admin')
    @include('layouts.admin.menus.portal_apps.admin')
@elseif ($role == 'Pegawai')
    @if ($sub_role == 'Admin Portal')
        @include('layouts.admin.menus.portal_apps.admin')
    @else
        @include('layouts.admin.menus.portal_apps.admin')
    @endif
@endif
