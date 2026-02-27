<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>TravelEasy – Ontdek de Wereld</title>

    <style>
        /* ---------- KLEUREN & BASIS ---------- */
        :root {
            --primary: #0077cc;
            --accent: #ff7f50;
            --dark: #1a1a1a;
            --light: #f7f7f7;
            --gray: #555;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            color: var(--dark);
            background: white;
        }

        a { text-decoration: none; color: inherit; }

        /* ---------- HERO ---------- */
        header {
            height: 100vh;
            background: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=2000&q=80') center/cover no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        header::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.45);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 20px;
            animation: fadeIn 1.2s ease-out;
        }

        header h1 {
            font-size: 3.8em;
            margin-bottom: 10px;
            font-weight: 700;
        }

        header p {
            font-size: 1.3em;
            opacity: 0.9;
        }

        /* Zoekbalk */
        .search-bar {
            margin-top: 30px;
            display: flex;
            background: white;
            border-radius: 50px;
            overflow: hidden;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .search-bar input {
            flex: 1;
            padding: 15px 20px;
            border: none;
            font-size: 1em;
        }

        .search-bar button {
            background: var(--accent);
            border: none;
            padding: 15px 30px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .search-bar button:hover {
            background: #ff5722;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ---------- SECTIES ---------- */
        section {
            padding: 80px 20px;
            max-width: 1300px;
            margin: auto;
        }

        section h2 {
            text-align: center;
            font-size: 2.6em;
            margin-bottom: 50px;
            color: var(--primary);
        }

        /* ---------- USP's ---------- */
        .usps {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 40px;
            text-align: center;
        }

        .usp {
            flex: 1 1 250px;
        }

        .usp i {
            font-size: 3em;
            color: var(--accent);
            margin-bottom: 15px;
        }

        .usp p {
            font-size: 1.1em;
            color: var(--gray);
        }

        /* ---------- BESTEMMINGEN ---------- */
        .bestemmingen {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 30px;
        }

        .bestemming {
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            height: 260px;
            cursor: pointer;
            transition: 0.3s;
        }

        .bestemming:hover {
            transform: scale(1.03);
        }

        .bestemming img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .bestemming .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.6em;
            font-weight: bold;
        }

        /* ---------- REIZEN ---------- */
        .reizen {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 35px;
        }

        .reis {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: 0.3s;
        }

        .reis:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.18);
        }

        .reis img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .reis-content {
            padding: 22px;
        }

        .reis h3 {
            margin: 0;
            color: var(--primary);
            font-size: 1.4em;
        }

        .reis .type {
            margin-top: 6px;
            font-weight: bold;
            color: var(--accent);
        }

        /* ---------- TESTIMONIALS ---------- */
        .testimonials {
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .testimonial {
            flex: 1 1 300px;
            background: var(--light);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .testimonial p {
            font-style: italic;
        }

        .testimonial .name {
            margin-top: 15px;
            font-weight: bold;
            color: var(--primary);
        }

        /* ---------- CTA BANNER ---------- */
        .cta-banner {
            background: var(--primary);
            color: white;
            padding: 60px 20px;
            text-align: center;
            border-radius: 12px;
            margin-top: 40px;
        }

        .cta-banner a {
            display: inline-block;
            margin-top: 20px;
            padding: 14px 36px;
            background: var(--accent);
            color: white;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: bold;
            transition: 0.3s;
        }

        .cta-banner a:hover {
            background: #ff5722;
        }

        /* ---------- FOOTER ---------- */
        footer {
            background: var(--dark);
            color: white;
            padding: 60px 20px;
            margin-top: 80px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 40px;
        }

        footer h3 {
            margin-bottom: 15px;
        }

        footer ul {
            list-style: none;
            padding: 0;
        }

        footer ul li {
            margin-bottom: 10px;
            color: #ccc;
        }

        footer ul li a {
            color: #ccc;
            transition: 0.3s;
        }

        footer ul li a:hover {
            color: white;
        }

        .footer-bottom {
            text-align: center;
            margin-top: 40px;
            color: #aaa;
        }

    </style>
</head>

<body>

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
            <img src="https://source.unsplash.com/600x400/?paris" alt="">
            <div class="overlay">Parijs</div>
        </div>
        <div class="bestemming">
            <img src="https://source.unsplash.com/600x400/?newyork" alt="">
            <div class="overlay">New York</div>
        </div>
        <div class="bestemming">
            <img src="https://source.unsplash.com/600x400/?tokyo" alt="">
            <div class="overlay">Tokyo</div>
        </div>
        <div class="bestemming">
            <img src="https://source.unsplash.com/600x400/?rome" alt="">
            <div class="overlay">Rome</div>
        </div>
    </div>
</section>

<section id="reizen">
    <h2>Onze Populaire Reizen</h2>
    <div class="reizen">
        @foreach($reizen as $reis)
            <div class="reis">
                <img src="https://source.unsplash.com/600x400/?{{ strtolower($reis['type']) }}" alt="{{ $reis['titel'] }}">
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

</body>
</html>
