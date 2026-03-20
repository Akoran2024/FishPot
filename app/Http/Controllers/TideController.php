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
        $start = Carbon::now()->startOfDay();
        // Request extremes for 7 days
        $end = Carbon::now()->addDays(6)->endOfDay();

        try {
            // If no API key, return sample data or error
            if (!$this->worldTidesApiKey) {
                return response()->json($this->getSampleData());
            }

            $response = Http::get('https://www.worldtides.info/api/v2/extremes', [
                'lat' => self::LATITUDE,
                'lon' => self::LONGITUDE,
                'key' => $this->worldTidesApiKey,
                'start' => $start->timestamp,
                'end' => $end->timestamp,
                'datum' => 'LAT', // Lowest Astronomical Tide
            ]);

            if ($response->failed()) {
                Log::error('WorldTides API failure: ' . $response->body());
                return response()->json($this->getSampleData());
            }

            $apiData = $response->json();

            if (isset($apiData['error'])) {
                Log::error('WorldTides API Error: ' . $apiData['error']);
                return response()->json($this->getSampleData());
            }

            return response()->json($this->formatTideData($apiData['extremes'], $start, $end));

        } catch (\Exception $e) {
            Log::error('Error fetching tide data: ' . $e->getMessage());
            return response()->json($this->getSampleData());
        }
    }

    private function formatTideData($extremes, $start, $end)
    {
        $week = [];
        $currentDate = $start->copy();

        // Group extremes by date
        $groupedExtremes = [];
        foreach ($extremes as $extreme) {
            $date = Carbon::createFromTimestamp($extreme['dt'])->toDateString();
            $groupedExtremes[$date][] = $extreme;
        }

        while ($currentDate->lessThanOrEqualTo($end)) {
            $dateString = $currentDate->toDateString();
            $dayTides = [];

            if (isset($groupedExtremes[$dateString])) {
                foreach ($groupedExtremes[$dateString] as $extreme) {
                    $time = Carbon::createFromTimestamp($extreme['dt']);
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

    private function getSampleData()
    {
        $week = [];
        $currentDate = Carbon::now()->startOfDay();
        
        for ($i = 0; $i < 7; $i++) {
            $week[] = [
                "date" => $currentDate->toDateString(),
                "day_name" => ucfirst($currentDate->translatedFormat('l')),
                "tides" => [
                    ["hora" => "03:15", "tipo" => "Bajamar", "altura" => 0.45],
                    ["hora" => "09:30", "tipo" => "Pleamar", "altura" => 2.10],
                    ["hora" => "15:45", "tipo" => "Bajamar", "altura" => 0.52],
                    ["hora" => "22:00", "tipo" => "Pleamar", "altura" => 2.05],
                ]
            ];
            $currentDate->addDay();
        }
        
        return $week;
    }
}

