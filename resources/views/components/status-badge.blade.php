@props(['status', 'type' => 'vluchtstatus'])

@php
    // Tailwind status badge styling (no Bootstrap dependency)
    $badgeClass = 'inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold';

    if ($type === 'vluchtstatus') {
        $badgeClass .= match(strtolower(trim($status ?? ''))) {
            'gepland' => ' bg-gray-200 text-gray-800',
            'vertrokken' => ' bg-blue-100 text-blue-800',
            'in vlucht' => ' bg-cyan-100 text-cyan-800',
            'geland' => ' bg-green-100 text-green-800',
            'vertraagd' => ' bg-amber-100 text-amber-900',
            'geannuleerd' => ' bg-red-100 text-red-800',
            'omgeleid' => ' bg-purple-100 text-purple-800',
            default => ' bg-gray-200 text-gray-800'
        };
    } elseif ($type === 'boekingsstatus') {
        $badgeClass .= match(strtolower(trim($status ?? ''))) {
            'in behandeling' => ' bg-amber-100 text-amber-900',
            'bevestigd' => ' bg-green-100 text-green-800',
            'betaald' => ' bg-emerald-100 text-emerald-800',
            'geannuleerd' => ' bg-red-100 text-red-800',
            'afgewezen' => ' bg-rose-100 text-rose-800',
            'wachtlijst' => ' bg-blue-100 text-blue-800',
            'onvolledig' => ' bg-gray-200 text-gray-800',
            default => ' bg-gray-200 text-gray-800'
        };
    } else {
        $badgeClass .= ' bg-gray-200 text-gray-800';
    }
@endphp

<span class="{{ $badgeClass }}">
    {{ $status ?? 'Onbekend' }}
</span>
