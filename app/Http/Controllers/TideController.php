<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Added for error logging

class TideController extends Controller
{
    private const LATITUDE = 29.035; // Lanzarote Latitude
    private const LONGITUDE = -13.633; // Lanzarote Longitude
    // User provided WorldTides API Key
    private $worldTidesApiKey; // Changed from const to private property

    public function __construct() // Add constructor
    {
        $this->worldTidesApiKey = env('WORLD_TIDES_API_KEY');
    }

    public function index()
    {
        $start = Carbon::now()->startOfDay();
        $end = Carbon::now()->addDays(6)->endOfDay(); // Get data for the next 7 days

        try {
            $response = Http::withOptions([
                'verify' => false, // Temporarily disable SSL verification for development only. DO NOT use in production!
            ])->get('https://www.worldtides.info/api/v2/tide', [
                'lat' => self::LATITUDE,
                'lon' => self::LONGITUDE,
                'key' => $this->worldTidesApiKey,
                'datum' => 'MSL', // Mean Sea Level - consistent with previous APIs
                'property' => 'height', // Request height data
                'start' => $start->timestamp, // WorldTides expects Unix timestamp
                'end' => $end->timestamp,     // WorldTides expects Unix timestamp
                'length' => 1440, // Request hourly data for the full 24 hours of each day (24*60/1)
            ]);

            $response->throw(); // Throw an exception for bad responses (4xx or 5xx)

            $apiData = $response->json();

            // Check for API errors reported by WorldTides
            if (isset($apiData['error'])) {
                throw new \Exception("WorldTides API Error: " . $apiData['error']);
            }

            if (!isset($apiData['heights']) || empty($apiData['heights'])) {
                return response()->json(['error' => 'No tide height data available from WorldTides API for the specified location and time.'], 500);
            }

            // Group hourly data by day
            $dailyTideHeights = [];
            foreach ($apiData['heights'] as $heightData) {
                $time = Carbon::createFromTimestamp($heightData['dt']);
                $date = $time->toDateString();
                $dailyTideHeights[$date][] = [
                    'time' => $time,
                    'height' => $heightData['height'],
                ];
            }
            
            $week = [];
            $currentDate = $start->copy();

            while ($currentDate->lessThanOrEqualTo($end)) {
                $dayTides = [];
                $currentDateString = $currentDate->toDateString();

                if (isset($dailyTideHeights[$currentDateString])) {
                    $hourlyDataForDay = $dailyTideHeights[$currentDateString];

                    if (!empty($hourlyDataForDay)) {
                        $minHeight = PHP_FLOAT_MAX;
                        $maxHeight = PHP_FLOAT_MIN;
                        $minTime = null;
                        $maxTime = null;
                        
                        foreach ($hourlyDataForDay as $hourData) {
                            if ($hourData['height'] < $minHeight) {
                                $minHeight = $hourData['height'];
                                $minTime = $hourData['time'];
                            }
                            if ($hourData['height'] > $maxHeight) {
                                $maxHeight = $hourData['height'];
                                $maxTime = $hourData['time'];
                            }
                        }

                        if ($maxTime) {
                            $dayTides[] = [
                                "hora" => $maxTime->format('H:i'),
                                "tipo" => "Pleamar",
                                "altura" => round($maxHeight, 2)
                            ];
                        }
                        if ($minTime && $minTime->format('H:i') !== $maxTime->format('H:i')) {
                             $dayTides[] = [
                                "hora" => $minTime->format('H:i'),
                                "tipo" => "Bajamar",
                                "altura" => round($minHeight, 2)
                            ];
                        }

                        usort($dayTides, function ($a, $b) {
                            return strtotime($a['hora']) - strtotime($b['hora']);
                        });
                    }
                }

                $week[] = [
                    "date" => $currentDate->toDateString(),
                    "day_name" => $currentDate->translatedFormat('l'),
                    "tides" => $dayTides
                ];

                $currentDate->addDay();
            }

            return response()->json($week);

        } catch (\Exception $e) {
            Log::error('Error fetching tide data from WorldTides API: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudieron cargar los datos de las mareas. Por favor, inténtelo de nuevo más tarde.'], 500);
        }
    }
}
