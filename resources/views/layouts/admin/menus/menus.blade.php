<?php
$auth = Auth::user();
$role = $auth->role;
?>

@if ($role == 'Super Admin')
    @include('layouts.admin.menus.sa')
@elseif ($role == 'BPKAD')
    @include('layouts.admin.menus.bpkad')
@elseif ($role == 'DINKES')
    @include('layouts.admin.menus.dinkes')
@elseif ($role == 'Puskesmas' || $role == 'RSUD')
    @include('layouts.admin.menus.puskesmas')
@endif
