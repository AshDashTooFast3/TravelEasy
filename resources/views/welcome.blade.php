@vite(['resources/css/app.css', 'resources/css/home.css'])

@php
    // Zet op true om onderhoud te tonen
    $maintenance = false;
@endphp

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>TravelEasy – Ontdek de Wereld</title>
</head>

<body>

    {{-- Onderhoudsmodus --}}
    @if ($maintenance)
        <x-navbar />

        <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 text-center px-6">
            <h1 class="text-4xl font-bold text-blue-600 mb-4">Tijdelijk niet beschikbaar</h1>
            <p class="text-gray-700 text-lg max-w-xl">
                De homepagina is momenteel niet beschikbaar vanwege onderhoud. Probeer het later opnieuw.
            </p>
        </div>

    @else
        {{-- Normale homepage --}}
        <x-navbar />

        <header>
            <div class="hero-content">
                <h1>Ontdek de Wereld met TravelEasy</h1>
                <p>Van luxe cruises tot avontuurlijke busreizen – wij brengen je overal.</p>

                <div class="search-bar">
                    <input type="text" placeholder="Waar wil je naartoe?">
                    <button>Zoeken</button>
                </div>
            </div>
        </header>

        <section>
            <h2>Waarom kiezen voor TravelEasy?</h2>
            <div class="usps">
                <div class="usp">
                    <i>✈️</i>
                    <h3>Complete verzorging</h3>
                    <p>Wij regelen alles: vluchten, hotels, transfers en excursies.</p>
                </div>
                <div class="usp">
                    <i>🛳️</i>
                    <h3>Premium cruises</h3>
                    <p>Geniet van luxe cruises naar de mooiste plekken ter wereld.</p>
                </div>
                <div class="usp">
                    <i>🚌</i>
                    <h3>Comfortabele busreizen</h3>
                    <p>Ontspannen reizen met moderne bussen en ervaren chauffeurs.</p>
                </div>
            </div>
        </section>

        <section id="bestemmingen">
            <h2>Populaire Bestemmingen</h2>
            <div class="bestemmingen">

                <div class="bestemming">
                    <img src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a?auto=format&fit=crop&w=800&q=80" alt="Parijs">
                    <div class="overlay">Parijs</div>
                </div>

                <div class="bestemming">
                    <img src="https://images.unsplash.com/photo-1485738422979-f5c462d49f74?auto=format&fit=crop&w=800&q=80" alt="New York">
                    <div class="overlay">New York</div>
                </div>

                <div class="bestemming">
                    <img src="https://images.unsplash.com/photo-1503899036084-c55cdd92da26?auto=format&fit=crop&w=800&q=80" alt="Tokyo">
                    <div class="overlay">Tokyo</div>
                </div>

                <div class="bestemming">
                    <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=800&q=80" alt="Rome">
                    <div class="overlay">Rome</div>
                </div>

            </div>
        </section>

        <section id="reizen">
            <h2>Onze Populaire Reizen</h2>
            <div class="reizen">
                @foreach($reizen as $reis)
                    <div class="reis">
                        @php
                            $images = [
                                'vliegtuig' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
                                'cruise' => 'https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=800&q=80',
                                'bus' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80',
                            ];
                        @endphp

                        <img src="{{ $images[strtolower($reis['type'])] ?? 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $reis['titel'] }}">
                        <div class="reis-content">
                            <h3>{{ $reis['titel'] }}</h3>
                            <p class="type">{{ $reis['type'] }}</p>
                            <p>{{ $reis['beschrijving'] }}</p>
                            <p><strong>Vanaf €{{ $reis['prijs'] }}</strong></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="reviews">
            <h2>Wat onze reizigers zeggen</h2>
            <div class="testimonials">
                <div class="testimonial">
                    <p>"Fantastische service! Onze cruise was perfect geregeld."</p>
                    <div class="name">– Sophie uit Utrecht</div>
                </div>
                <div class="testimonial">
                    <p>"De busreis naar Italië was super comfortabel en goed georganiseerd."</p>
                    <div class="name">– Mark uit Eindhoven</div>
                </div>
                <div class="testimonial">
                    <p>"Snelle communicatie en geweldige hotels. Zeker een aanrader!"</p>
                    <div class="name">– Lisa uit Rotterdam</div>
                </div>
            </div>
        </section>

        <section>
            <div class="cta-banner">
                <h2>Klaar voor jouw volgende avontuur?</h2>
                <p>Boek vandaag nog en profiteer van onze speciale aanbiedingen.</p>
                <a href="#reizen">Bekijk reizen</a>
            </div>
        </section>

        <footer id="contact">
            <div class="footer-grid">
                <div>
                    <h3>TravelEasy</h3>
                    <p>Jouw partner voor onvergetelijke reizen.</p>
                </div>

                <div>
                    <h3>Links</h3>
                    <ul>
                        <li><a href="#bestemmingen">Bestemmingen</a></li>
                        <li><a href="#reizen">Reizen</a></li>
                        <li><a href="#reviews">Reviews</a></li>
                    </ul>
                </div>

                <div>
                    <h3>Contact</h3>
                    <ul>
                        <li>info@traveleasy.nl</li>
                        <li>030 - 123 4567</li>
                        <li>Utrecht, Nederland</li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                © 2026 TravelEasy – Alle rechten voorbehouden
            </div>
        </footer>

    @endif

</body>
</html>
