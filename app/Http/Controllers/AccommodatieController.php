<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accommodatie;
use Exception;
use Illuminate\Support\Facades\Log;

class AccommodatieController extends Controller
{
    /**
     * Display all accommodations
     * Retrieves all accommodations from database and returns index view
     */
    public function index()
    {
        $code = 98465;
        try {
            // Log the start of index action
            Log::info('AccommodatieController@index: Starting to fetch all accommodations');
            
            // Retrieve all accommodations from database
            $accommodaties = Accommodatie::all();
            
            // Log successful retrieval
            Log::info('AccommodatieController@index: Successfully fetched ' . count($accommodaties) . ' accommodations');
            
            return view('accomodatie.index')
            ->with('accommodaties', $accommodaties)
            ->with('code', $code);
        } catch (Exception $e) {
            // Log the error that occurred
            Log::error('AccommodatieController@index: Error loading accommodations - ' . $e->getMessage());
            
            return redirect()->route('accommodatie.index')->with('error', 'Fout bij laden accommodaties: ' . $e->getMessage());
        }
    }

    /**
     * Show the edit form for a specific accommodation
     * Finds accommodation by ID and returns edit view
     */
    public function edit($id)
    {
        try {
            // Log the edit request with accommodation ID
            Log::info('AccommodatieController@edit: Fetching accommodation with ID: ' . $id);
            
            // Find accommodation or fail with 404
            $accommodatie = Accommodatie::findOrFail($id);
            
            // Log successful fetch
            Log::info('AccommodatieController@edit: Successfully fetched accommodation ID: ' . $id);
            
            return view('accomodatie.edit', compact('accommodatie'));
        } catch (Exception $e) {
            // Log accommodation not found error
            Log::error('AccommodatieController@edit: Accommodation not found with ID: ' . $id . ' - ' . $e->getMessage());
            
            return redirect()->route('accommodatie.index')->with('error', 'Accommodatie niet gevonden: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing accommodation
     * Validates input and updates accommodation record in database
     */
    public function update(Request $request, $id)
    {
        try {
            // Log the update request with accommodation ID
            Log::info('AccommodatieController@update: Starting update for accommodation ID: ' . $id);
            
            // Find accommodation or fail with 404
            $accommodatie = Accommodatie::findOrFail($id);
            
            // Log found accommodation
            Log::debug('AccommodatieController@update: Found accommodation, validating input');

            // Validate incoming request data
            $request->validate([
                'Naam' => 'required|string|max:255',
                'Type' => 'required|string|max:255',
                'Straat' => 'required|string|max:255',
                'Huisnummer' => 'required|string|max:10',
                'toevoeging' => 'nullable|string|max:10',
                'Postcode' => 'required|string|max:10',
                'Stad' => 'required|string|max:255',
                'Land' => 'required|string|max:255',
                'AantalKamers' => 'required|integer|min:1',
                'AantalPersonen' => 'required|integer|min:1',
                'PrijsPerNacht' => 'required|numeric|min:0',
                'TotaalPrijs' => 'required|numeric|min:0',
            ]);

            // Log validation passed
            Log::debug('AccommodatieController@update: Validation passed, updating record');

            // Prepare data for update
            $updateData = $request->only([
                'Naam', 'Type', 'Straat', 'Huisnummer', 'toevoeging',
                'Postcode', 'Stad', 'Land', 'AantalKamers', 'AantalPersonen',
                'PrijsPerNacht', 'TotaalPrijs', 
            ]);

            // Check if any data has changed
            $hasChanges = false;
            foreach ($updateData as $key => $value) {
                if ($accommodatie->$key != $value) {
                    $hasChanges = true;
                    break;
                }
            }

            if (!$hasChanges) {
                // Log no changes found
                Log::info('AccommodatieController@update: No changes detected for accommodation ID: ' . $id);
                
                return redirect()->back()->with('error', 'U moet eerst iets wijzigen voordat u kunt opslaan')->withInput();
            }

            // Update accommodation with validated data
            $accommodatie->update($updateData);

            // Log successful update
            Log::info('AccommodatieController@update: Successfully updated accommodation ID: ' . $id);

            return redirect()->route('accommodatie.index')->with('success', 'Accommodatie bijgewerkt!');
        } catch (Exception $e) {
            // Log update error
            Log::error('AccommodatieController@update: Error updating accommodation ID: ' . $id . ' - ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Fout bij bijwerken: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the create form for a new accommodation
     * Fetches all flights and returns create view
     */
    public function create()
    {
        try {
            // Log the create request
            Log::info('AccommodatieController@create: Loading create form');
            
            // Fetch all flights for selection dropdown
            $vluchten = \App\Models\Vlucht::all();
            
            // Log successful fetch of flights
            Log::info('AccommodatieController@create: Successfully fetched ' . count($vluchten) . ' flights');
            
            return view('accomodatie.create', compact('vluchten'));
        } catch (Exception $e) {
            // Log error loading form
            Log::error('AccommodatieController@create: Error loading create form - ' . $e->getMessage());
            
            return redirect()->route('accommodatie.index')->with('error', 'Fout bij laden formulier: ' . $e->getMessage());
        }
    }

    /**
     * Store a new accommodation in the database
     * Validates input, checks for duplicates, and creates new accommodation record
     */
    public function store(Request $request)
    {
        try {
            // Log the store request
            Log::info('AccommodatieController@store: Starting to store new accommodation');
            
            // Validate incoming request data
            $request->validate([
                'Naam' => 'required|string|max:255',
                'Type' => 'required|string|max:255',
                'Straat' => 'required|string|max:255',
                'Huisnummer' => 'required|string|max:10',
                'toevoeging' => 'nullable|string|max:10',
                'Postcode' => 'required|string|max:10',
                'Stad' => 'required|string|max:255',
                'Land' => 'required|string|max:255',
                'AantalKamers' => 'required|integer|min:1',
                'AantalPersonen' => 'required|integer|min:1',
                'PrijsPerNacht' => 'required|numeric|min:0',
                'TotaalPrijs' => 'required|numeric|min:0',
                'Vluchtnummer' => 'required|string|max:255',
                'CheckInDatum' => 'required|date',
                'CheckOutDatum' => 'required|date',
                'Opmerking' => 'nullable|string|max:1000',
            ]);

            // Log validation passed
            Log::debug('AccommodatieController@store: Validation passed');

            // Fetch flight where Vluchtnummer matches
            Log::debug('AccommodatieController@store: Looking up flight with Vluchtnummer: ' . $request->input('Vluchtnummer'));
            $vlucht = \App\Models\Vlucht::where('Vluchtnummer', $request->input('Vluchtnummer'))->first();
            
            if (!$vlucht) {
                // Log flight not found
                Log::warning('AccommodatieController@store: Flight not found with Vluchtnummer: ' . $request->input('Vluchtnummer'));
                
                return redirect()->back()->withErrors(['Vluchtnummer' => 'Ongeldige Vluchtnummer'])->withInput();
            }

            // Log flight found
            Log::debug('AccommodatieController@store: Found flight ID: ' . $vlucht->Id);

            // Check if accommodation already exists
            Log::debug('AccommodatieController@store: Checking for duplicate accommodations');
            $exists = Accommodatie::where('Naam', $request->input('Naam'))
                ->where('Straat', $request->input('Straat'))
                ->where('Huisnummer', $request->input('Huisnummer'))
                ->whereDate('CheckInDatum', $request->input('CheckInDatum'))
                ->exists();
            
            if ($exists) {
                // Log duplicate found
                Log::warning('AccommodatieController@store: Duplicate accommodation found - Naam: ' . $request->input('Naam'));
                
                return redirect()->back()->withErrors(['Naam' => 'Deze accommodatie bestaat al'])->withInput();
            }

            // Log no duplicate found
            Log::debug('AccommodatieController@store: No duplicates found, proceeding with creation');

            // Prepare data for creation
            $data = $request->only([
                'Naam', 'Type', 'Straat', 'Huisnummer', 'toevoeging',
                'Postcode', 'Stad', 'Land', 'AantalKamers', 'AantalPersonen',
                'PrijsPerNacht', 'TotaalPrijs', 'CheckInDatum', 'CheckOutDatum', 'Opmerking'
            ]);
            $data['VluchtId'] = $vlucht->Id;
            
            // Log data being created
            Log::debug('AccommodatieController@store: Creating accommodation with data', $data);
            
            // Create accommodation record
            Accommodatie::create($data);

            // Log successful creation
            Log::info('AccommodatieController@store: Successfully created accommodation - Naam: ' . $request->input('Naam'));

            return redirect()->route('accommodatie.index')->with('success', 'Accommodatie toegevoegd!');
        } catch (Exception $e) {
            // Log store error
            Log::error('AccommodatieController@store: Error creating accommodation - ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Fout bij toevoegen: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete an accommodation from the database
     * Finds accommodation by ID and removes it
     */
    public function delete($id)
    {
        try {
            // Log the delete request
            Log::info('AccommodatieController@delete: Starting delete for accommodation ID: ' . $id);
            
            // Find accommodation or fail with 404
            $accommodatie = Accommodatie::findOrFail($id);
            
            // Log found accommodation
            Log::debug('AccommodatieController@delete: Found accommodation, proceeding with deletion');
            
            // Delete the accommodation
            $accommodatie->delete();

            // Log successful deletion
            Log::info('AccommodatieController@delete: Successfully deleted accommodation ID: ' . $id);

            return redirect()->route('accommodatie.index')->with('success', 'Accommodatie verwijderd!');
        } catch (Exception $e) {
            // Log deletion error
            Log::error('AccommodatieController@delete: Error deleting accommodation ID: ' . $id . ' - ' . $e->getMessage());
            
            return redirect()->route('accommodatie.index')->with('error', 'Fout bij verwijderen: ' . $e->getMessage());
        }
    }

}
