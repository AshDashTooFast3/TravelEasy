@if (Route::currentRouteName() === 'welcome' && !request()->is('nav*'))
    <img src="{{ asset('img/traveleasy-logo-groot.png') }}" alt="TravelEasy-logo" class="logo-groot" />
@elseif (in_array(Route::currentRouteName(), ['dashboard', 'management-dashboard']))
    <img src="{{ asset('img/traveleasy-logo-dashboard.png') }}" alt="TravelEasy-logo" class="logo-dashboard" />
@else
    <img src="{{ asset('img/traveleasy-logo-klein.png') }}" alt="TravelEasy-logo" class="logo-klein" />
@endif