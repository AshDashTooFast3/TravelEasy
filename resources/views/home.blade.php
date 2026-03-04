<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>TravelEasy - Jouw Reisbureau</title>
    <style>
        /* Algemene styling */
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Header / Hero */
        header {
            background: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1950&q=80') center/cover no-repeat;
            color: white;
            text-align: center;
            padding: 120px 20px;
            position: relative;
        }

        header::after {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 0;
        }

        header div {
            position: relative;
            z-index: 1;
        }

        header h1 {
            font-size: 3em;
            margin-bottom: 10px;
        }

        header p {
            font-size: 1.3em;
        }

        .cta-button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background-color: #ff7f50;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .cta-button:hover {
            background-color: #ff5722;
        }

        /* Secties */
        section {
            padding: 60px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        section h2 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 40px;
            color: #0077cc;
        }

        /* Over ons */
        .about {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            text-align: center;
        }

        .about div {
            flex: 1 1 300px;
        }

        /* Reizen cards */
        .reizen {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .reis {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .reis:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0,0,0,0.2);
        }

        .reis img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .reis-content {
            padding: 20px;
        }

        .reis h3 {
            margin-top: 0;
            color: #0077cc;
        }

        .reis .type {
            font-weight: bold;
            color: #ff7f50;
            margin-bottom: 10px;
        }

        .reis p {
            margin: 5px 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            header h1 { font-size: 2.2em; }
            header p { font-size: 1em; }
        }
    </style>
</head>
<body>

<header>
    <div>
        <h1>Welkom bij TravelEasy</h1>
        <p>De mooiste reizen per vliegtuig, cruise en bus</p>
        <a href="#reizen" class="cta-button">Bekijk onze reizen</a>
    </div>
</header>

<section class="about">
    <div>
        <h2>Over ons</h2>
        <p>
            TravelEasy organiseert onvergetelijke reizen over de hele wereld. 
            Kies voor een luxe cruise, een comfortabele busreis of een snelle vliegvakantie, 
            wij regelen alles tot in de puntjes voor jou!
        </p>
    </div>
</section>

<section id="reizen">
    <h2>Onze populaire reizen</h2>
    <div class="reizen">
        @foreach($reizen as $reis)
            <div class="reis">
                <img src="https://source.unsplash.com/400x200/?{{ strtolower($reis['type']) }}" alt="{{ $reis['titel'] }}">
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

</body>
</html>