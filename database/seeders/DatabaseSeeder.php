<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Gebruiker;
use App\Models\Persoon;
use App\Models\Passagier;
use App\Models\Medewerker;
use App\Models\Ticket;
use Mockery\Generator\StringManipulation\Pass\Pass;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Admin account
        Gebruiker::factory()->create([
            'Gebruikersnaam' => 'Admin',
            'Wachtwoord' => bcrypt('achraf123'),
            'RolNaam' => 'Administrator',
            'Email' => 'admin@traveleasy.com',
            'Ingelogd' => now(),
            'Uitgelogd' => null,
            'Isactief' => true,
            'remember_token'   => Str::random(10),
        ]);

        Persoon::factory()->create([
            'GebruikerId' => 1,
            'Voornaam' => 'Achraf',
            'Tussenvoegsel' => 'El',
            'Achternaam' => 'Arrasi',
            'Geboortedatum' => '2006-01-01',
            'Isactief' => true,
        ]);

        //Passagier account
        Gebruiker::factory()->create([
            'Gebruikersnaam' => 'Passagier',
            'Wachtwoord' => bcrypt('achraf123'),
            'RolNaam' => 'Passagier',
            'Email' => 'passagier@traveleasy.com',
            'Ingelogd' => now(),
            'Uitgelogd' => null,
            'Isactief' => true,
            'remember_token'   => Str::random(10)
        ]);
        
        Persoon::factory()->create([
            'GebruikerId' => 2,
            'Voornaam' => 'Luuk',
            'Tussenvoegsel' => 'van',
            'Achternaam' => 'der Bilt',
            'Geboortedatum' => '2006-01-01',
            'Isactief' => true,
        ]);

        Passagier::factory()->create([
            'PersoonId' => 2,
            'Nummer' => 'P001',
            'PassagierType' => 'Volwassen',
            'IsActief' => true,
        ]);

        //Medewerker account
        Gebruiker::factory()->create([
            'Gebruikersnaam' => 'Medewerker',
            'Wachtwoord' => bcrypt('achraf123'),
            'RolNaam' => 'Medewerker',
            'Email' => 'medewerker@traveleasy.com',
            'Ingelogd' => now(),
            'Uitgelogd' => null,
            'Isactief' => true,
            'remember_token'   => Str::random(10)
        ]);

        Persoon::factory()->create([
            'GebruikerId' => 3,
            'Voornaam' => 'Welsey',
            'Tussenvoegsel' => null,
            'Achternaam' => 'Borgman',
            'Geboortedatum' => '1990-05-15',
            'Isactief' => true,
        ]);

        Medewerker::factory()->create([
            'PersoonId' => 3,
            'Nummer' => 'M001',
            'Medewerkertype' => 'Piloot',
            'Specialisatie' => 'Vliegtuigbesturing',
            'Beschikbaarheid' => 'Fulltime (40 uur)',
            'Isactief' => true,
        ]);

        // Generate additional random data for testing
        $this->call([
            PassagierSeeder::class,
            MedewerkerSeeder::class,
            VluchtSeeder::class,
            AccommodatieSeeder::class,
            TicketSeeder::class,
            FactuurSeeder::class,
        ]);

    }
}
