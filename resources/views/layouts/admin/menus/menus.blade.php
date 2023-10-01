@if (Request::is('portal-apps*'))
    @include('layouts.admin.menus.portal_apps.menus')
@elseif (Request::is('settings-apps*'))
    @include('layouts.admin.menus.settings_apps.menus')
@endif
