@if (Request::is('portal-apps*'))
    @include('layouts.admin.menus.portal_apps.menus')
@elseif (Request::is('settings-apps*'))
    @include('layouts.admin.menus.settings_apps.menus')
@elseif (Request::is('schedule-apps*'))
    @include('layouts.admin.menus.schedule_apps.menus')
@elseif (Request::is('supervision-apps*'))
    @include('layouts.admin.menus.supervision_apps.menus')
@endif
