<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

class TideController extends Controller
{
    private const LATITUDE = 29.035; // Lanzarote Latitude
    private const LONGITUDE = -13.633; // Lanzarote Longitude
    private $worldTidesApiKey;

    public function __construct()
    {
        $this->worldTidesApiKey = env('WORLD_TIDES_API_KEY');
        Carbon::setLocale('es');
    }

    public function index()
    {
        $timezone = 'Atlantic/Canary';
        $start = Carbon::now($timezone)->startOfDay();
        // Request for 7 days
        $days = 7;

        try {
            // If no API key, return sample data
            if (!$this->worldTidesApiKey) {
                return response()->json($this->getSampleData($timezone));
            }

            // Using v3 API with correct parameters
            $response = Http::get('https://www.worldtides.info/api/v3', [
                'extremes' => true,
                'lat' => self::LATITUDE,
                'lon' => self::LONGITUDE,
                'key' => $this->worldTidesApiKey,
                'start' => $start->timestamp,
                'length' => $days * 24 * 3600, // 7 days in seconds
                'datum' => 'LAT', // Lowest Astronomical Tide
            ]);

            if ($response->failed()) {
                Log::error('WorldTides API failure: ' . $response->status() . ' ' . $response->body());
                return response()->json($this->getSampleData($timezone));
            }

            $apiData = $response->json();

            if (isset($apiData['error']) || !isset($apiData['extremes'])) {
                Log::error('WorldTides API Error: ' . ($apiData['error'] ?? 'No extremes data found'));
                return response()->json($this->getSampleData($timezone));
            }

            // The end date for the loop
            $end = $start->copy()->addDays($days - 1)->endOfDay();

            return response()->json($this->formatTideData($apiData['extremes'], $start, $end, $timezone));

        } catch (\Exception $e) {
            Log::error('Error fetching tide data: ' . $e->getMessage());
            return response()->json($this->getSampleData($timezone));
        }
    }

    private function formatTideData($extremes, $start, $end, $timezone)
    {
        $week = [];
        $currentDate = $start->copy();

        // Group extremes by date in the local timezone
        $groupedExtremes = [];
        foreach ($extremes as $extreme) {
            $date = Carbon::createFromTimestamp($extreme['dt'], $timezone)->toDateString();
            $groupedExtremes[$date][] = $extreme;
        }

        while ($currentDate->lessThanOrEqualTo($end)) {
            $dateString = $currentDate->toDateString();
            $dayTides = [];

            if (isset($groupedExtremes[$dateString])) {
                foreach ($groupedExtremes[$dateString] as $extreme) {
                    $time = Carbon::createFromTimestamp($extreme['dt'], $timezone);
                    $dayTides[] = [
                        "hora" => $time->format('H:i'),
                        "tipo" => (stripos($extreme['type'], 'High') !== false) ? "Pleamar" : "Bajamar",
                        "altura" => round($extreme['height'], 2)
                    ];
                }
            }

            $week[] = [
                "date" => $dateString,
                "day_name" => ucfirst($currentDate->translatedFormat('l')),
                "tides" => $dayTides
            ];

            $currentDate->addDay();
        }

        return $week;
    }

    private function getSampleData($timezone)
    {
        $week = [];
        $currentDate = Carbon::now($timezone)->startOfDay();
        
        // Base tides for day 0 (simulated)
        $baseTides = [
            ["hora" => "03:15", "tipo" => "Bajamar", "altura" => 0.45],
            ["hora" => "09:30", "tipo" => "Pleamar", "altura" => 2.10],
            ["hora" => "15:45", "tipo" => "Bajamar", "altura" => 0.52],
            ["hora" => "22:00", "tipo" => "Pleamar", "altura" => 2.05],
        ];

        for ($i = 0; $i < 7; $i++) {
            $dayTides = [];
            foreach ($baseTides as $tide) {
                // Tides shift approximately 50 minutes later each day
                $time = Carbon::createFromFormat('H:i', $tide['hora'], $timezone);
                $time->addMinutes($i * 50);
                
                $dayTides[] = [
                    "hora" => $time->format('H:i'),
                    "tipo" => $tide['tipo'],
                    "altura" => round($tide['altura'] + (sin($i * 0.5) * 0.15), 2) // Add some variation to heights
                ];
            }

            $week[] = [
                "date" => $dateString = $currentDate->toDateString(),
                "day_name" => ucfirst($currentDate->translatedFormat('l')),
                "tides" => $dayTides
            ];
            $currentDate->addDay();
        }
        
        return $week;
    }
}

