@if (Request::is('portal-apps*'))
    @include('layouts.admin.headers.portal')
@elseif(Request::is('pdp-apps*'))
    @include('layouts.admin.headers.pdp')
@else
@endif
