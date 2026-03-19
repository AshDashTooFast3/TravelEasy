<?php

namespace App\Http\Controllers;

use App\Models\Boeking;
use Illuminate\Support\Facades\Log;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class MedewerkerController extends Controller
{
    private $BoekingModel;

    public function __construct()
    {
        $this->BoekingModel = new Boeking;
    }

    // pagina voor alle medewerkers
    public function index()
    {
        return view('dashboard');
    }

    // Alleen Administrators en Managers kunnen deze pagina zien
    // ...existing code...

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

    private function haalAantalBoekingenOp(): int
    {
        try {
            $aantalBoekingen = $this->BoekingModel->sp_PakBoekingenAantal();

            if (! $aantalBoekingen) {
                Log::info('Er is een fout opgetreden bij de AantalBoekingen stored procedure');

                return 0;
            }

            Log::info('Aantal boekingen: '.$aantalBoekingen);

            if ($aantalBoekingen > 0) {
                Log::info('Boekingen opgehaald: '.$aantalBoekingen);
            } else {
                Log::info('Geen boekingen gevonden in de database.');
            }

            return (int) $aantalBoekingen;
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen van aantal boekingen: '.$e->getMessage());

            return 0;
        }
    }

    private function haalMeestVoorkomendeReisOp(): array
    {
        try {
            $meestVoorkomendeReis = $this->BoekingModel->sp_MeestVoorkomendeReis();

            if (! $meestVoorkomendeReis) {
                Log::info('Er is een fout opgetreden bij de MeestVoorkomendeReis stored procedure');

                return [];
            }

            Log::info('Boekingen voor meest voorkomende reis bestaan');

            return is_array($meestVoorkomendeReis)
                ? $meestVoorkomendeReis
                : (array) $meestVoorkomendeReis;
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen van meest voorkomende reis: '.$e->getMessage());

            return [];
        }
    }

    private function maakBoekingenGrafiek(): ?LaravelChart
    {
        try {
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

            // dd($grafiekOpties['boekingencount']);

            Log::info('Grafiekopties: '.json_encode($grafiekOpties).'. zijn succesvol opgehaald. Grafiek kan worden gegenereerd.');

            return new LaravelChart($grafiekOpties);

        } catch (\Exception $e) {
            Log::error('Fout bij maken van de grafiek: '.$e->getMessage());

            return null;
        }
    }
}
