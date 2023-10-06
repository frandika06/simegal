@if (Request::is('portal-apps*'))
    @include('layouts.admin.headers.portal')
@elseif(Request::is('pdp-apps*'))
    @include('layouts.admin.headers.pdp')
@elseif(Request::is('settings-apps*'))
    @include('layouts.admin.headers.settings')
@elseif(Request::is('schedule-apps*'))
    @include('layouts.admin.headers.schedule')
@endif
