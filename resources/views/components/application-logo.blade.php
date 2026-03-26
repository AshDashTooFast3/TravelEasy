@if (in_array(Route::currentRouteName(), ['dashboard', 'management-dashboard', 'facturatie.index', 'reis.index', 'welcome', 'ticket.index', 'boekingen.index', 'reis.show', 'ticket.show', 'accommodatie.index', 'facturatie.bewerken', 'boekingen.edit', 'boekingen.create', 'accommodaties.edit', 'accommodaties.create' ]))
    <img src="{{ asset('img/traveleasy-logo-dashboard.png') }}" alt="TravelEasy-logo" class="logo-dashboard" />
@else
    <img src="{{ asset('img/traveleasy-logo.png') }}" alt="TravelEasy-logo" class="logo-klein" />
@endif