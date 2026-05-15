<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

class TideController extends Controller
{
    private const LATITUDE = 29.035; // Latitud de Lanzarote
    private const LONGITUDE = -13.633; // Longitud de Lanzarote
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
        // Solicitar datos para 7 días
        $days = 7;

        try {
            // Si no hay clave de API, devolver datos de ejemplo (simulados)
            if (!$this->worldTidesApiKey) {
                return response()->json($this->getSampleData($timezone));
            }

            // Uso de la API v3 con los parámetros correctos
            $response = Http::get('https://www.worldtides.info/api/v3', [
                'extremes' => true,
                'lat' => self::LATITUDE,
                'lon' => self::LONGITUDE,
                'key' => $this->worldTidesApiKey,
                'start' => $start->timestamp,
                'length' => $days * 24 * 3600, // 7 días en segundos
                'datum' => 'LAT', // Lowest Astronomical Tide (Bajamar Astronómica más baja)
            ]);

            if ($response->failed()) {
                Log::error('Fallo en la API WorldTides: ' . $response->status() . ' ' . $response->body());
                return response()->json($this->getSampleData($timezone));
            }

            $apiData = $response->json();

            if (isset($apiData['error']) || !isset($apiData['extremes'])) {
                Log::error('Error en la API WorldTides: ' . ($apiData['error'] ?? 'No se encontraron datos de extremos'));
                return response()->json($this->getSampleData($timezone));
            }

            // Fecha final para el bucle
            $end = $start->copy()->addDays($days - 1)->endOfDay();

            return response()->json($this->formatTideData($apiData['extremes'], $start, $end, $timezone));

        } catch (\Exception $e) {
            Log::error('Error obteniendo datos de mareas: ' . $e->getMessage());
            return response()->json($this->getSampleData($timezone));
        }
    }

    /**
     * Formatea los datos de mareas recibidos de la API.
     */
    private function formatTideData($extremes, $start, $end, $timezone)
    {
        $week = [];
        $currentDate = $start->copy();

        // Agrupar extremos por fecha en la zona horaria local
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

    /**
     * Genera datos simulados en caso de que la API no esté disponible.
     */
    private function getSampleData($timezone)
    {
        $week = [];
        $currentDate = Carbon::now($timezone)->startOfDay();
        
        // Mareas base para el día 0 (simuladas)
        $baseTides = [
            ["hora" => "03:15", "tipo" => "Bajamar", "altura" => 0.45],
            ["hora" => "09:30", "tipo" => "Pleamar", "altura" => 2.10],
            ["hora" => "15:45", "tipo" => "Bajamar", "altura" => 0.52],
            ["hora" => "22:00", "tipo" => "Pleamar", "altura" => 2.05],
        ];

        for ($i = 0; $i < 7; $i++) {
            $dayTides = [];
            foreach ($baseTides as $tide) {
                // Las mareas se desplazan aproximadamente 50 minutos cada día
                $time = Carbon::createFromFormat('H:i', $tide['hora'], $timezone);
                $time->addMinutes($i * 50);
                
                $dayTides[] = [
                    "hora" => $time->format('H:i'),
                    "tipo" => $tide['tipo'],
                    "altura" => round($tide['altura'] + (sin($i * 0.5) * 0.15), 2) // Pequeña variación en la altura
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
