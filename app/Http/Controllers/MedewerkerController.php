<?php

namespace App\Http\Controllers;

use App\Models\Boeking;
use Illuminate\Support\Facades\Log;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class MedewerkerController extends Controller
{
    // Model voor Boeking
    private $BoekingModel;

    /**
     * Constructor - initialiseert de BoekingModel
     */
    public function __construct()
    {
        $this->BoekingModel = new Boeking;
    }

    /**
     * pagina voor alle medewerkers
     * Retourneert het dashboard view
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Management Dashboard
     * Haalt alle benodigde gegevens op en retourneert het management dashboard view
     */
    public function ManagementDashboard()
    {
        $aantalBoekingen = $this->haalAantalBoekingenOp();
        $meestVoorkomendeReis = $this->haalMeestVoorkomendeReisOp();
        $chart1 = $this->maakBoekingenGrafiek();

        return view('management-dashboard', [
            'title' => 'Management Dashboard',
            'AantalBoekingen' => $aantalBoekingen,
            'MeestVoorkomendeReis' => $meestVoorkomendeReis,
            'chart1' => $chart1,
        ]);
    }

    /**
     * Haalt het aantal boekingen op uit de database
     * Retourneert het aantal boekingen als integer, of 0 bij fout
     */
    private function haalAantalBoekingenOp(): int
    {
        try {
            // Roept de stored procedure aan om het aantal boekingen op te halen
            $aantalBoekingen = $this->BoekingModel->sp_PakBoekingenAantal();

            // Controleer of de stored procedure een resultaat heeft teruggegeven
            if (! $aantalBoekingen) {
                Log::info('Er is een fout opgetreden bij de AantalBoekingen stored procedure');

                return 0;
            }

            Log::info('Aantal boekingen: '.$aantalBoekingen);

            // Log het aantal opgehaalde boekingen
            if ($aantalBoekingen > 0) {
                Log::info('Boekingen opgehaald: '.$aantalBoekingen);
            } else {
                Log::info('Geen boekingen gevonden in de database.');
            }

            // Retourneer het aantal als integer
            return (int) $aantalBoekingen;
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen van aantal boekingen: '.$e->getMessage());

            return 0;
        }
    }

    /**
     * Haalt de meest voorkomende reis op uit de database
     * Retourneert een array met reisgegevens, of lege array bij fout
     */
    private function haalMeestVoorkomendeReisOp(): array
    {
        try {
            // sp_MeestVoorkomendeReis wordt hier aangeroepen
            $meestVoorkomendeReis = $this->BoekingModel->sp_MeestVoorkomendeReis();

            // Log als er iets fout gaat tijdens het ophalen van de meest voorkomende reis
            if (! $meestVoorkomendeReis) {
                Log::info('Er is een fout opgetreden bij de MeestVoorkomendeReis stored procedure');

                return [];
            }

            // Controleer of het resultaat een array is en log succes
            Log::info('Boekingen voor meest voorkomende reis bestaan');

            // Zet het resultaat om naar een array indien nodig
            return is_array($meestVoorkomendeReis)
                ? $meestVoorkomendeReis
                : (array) $meestVoorkomendeReis;
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen van meest voorkomende reis: '.$e->getMessage());

            return [];
        }
    }

    /**
     * Maakt een grafiek aan met het aantal boekingen per jaar
     * Retourneert een LaravelChart object, of null bij fout
     */
    private function maakBoekingenGrafiek(): ?LaravelChart
    {
        /* We maken gebruik van een laravel package genaamd Laravel Charts om een grafiek te genereren op basis van de boekingen in de database.
        voor meer informatie, bekijk zijn github pagina: https://github.com/LaravelDaily/laravel-charts
        */

        // Grafiekopties instellen
        try {
            // Configuratie voor de grafiek met boekingsgegevens
            $grafiekOpties = [
                'chart_title' => 'Aantal boekingen per jaar',
                'report_type' => 'group_by_date',
                'model' => Boeking::class,
                'group_by_field' => 'Boekingsdatum',
                'group_by_period' => 'year',
                'chart_type' => 'bar',
                'aggregate_function' => 'count',
                'aggregate_field' => 'Id',
                'boekingencount' => Boeking::count(),
            ];

            // Log of de grafiekopties correct zijn ingesteld en succesvol zijn opgehaald
            Log::info('Grafiekopties succesvol ingesteld. Grafiek wordt gegenereerd.', $grafiekOpties);

            // Retourneer de LaravelChart instantie met de ingestelde opties
            return new LaravelChart($grafiekOpties);
            // Gooit een fout als er iets misgaat bij het maken van de grafiek, zoals een databasefout of een fout in de grafiekconfiguratie
        } catch (\Exception $e) {
            Log::error('Fout bij maken van de grafiek: '.$e->getMessage());

            return null;
        }
    }
}
