@if (in_array(Route::currentRouteName(), ['dashboard', 'management-dashboard', 'facturatie.index', 'reis.index','welcome', 'ticket.index', 'boekingen.index']))
    <img src="{{ asset('img/traveleasy-logo-dashboard.png') }}" alt="TravelEasy-logo" class="logo-dashboard" />
@else
    <img src="{{ asset('img/traveleasy-logo.png') }}" alt="TravelEasy-logo" class="logo-klein" />
@endif