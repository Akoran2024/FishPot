<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class TideController extends Controller
{
    public function index()
    {
        app()->setLocale('es');
        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();
        
        $monthsToFetch = [
            $startOfWeek->format('Ym'),
            $endOfWeek->format('Ym')
        ];
        $monthsToFetch = array_unique($monthsToFetch);
        
        $allTides = [];
        $portId = 42; // Cádiz

        foreach ($monthsToFetch as $month) {
            $response = Http::get("https://ideihm.covam.es/api-ihm/getmarea", [
                'request' => 'gettide',
                'id' => $portId,
                'format' => 'json',
                'month' => $month
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $monthTides = $data['mareas']['datos']['marea'] ?? [];
                $allTides = array_merge($allTides, $monthTides);
            }
        }

        if (empty($allTides)) {
            return response()->json(['error' => 'Failed to fetch tide data'], 500);
        }

        $weeklyTides = array_filter($allTides, function ($tide) use ($startOfWeek, $endOfWeek) {
            $tideDate = Carbon::parse($tide['fecha']);
            return $tideDate->between($startOfWeek, $endOfWeek);
        });

        // Sort by date and time
        usort($weeklyTides, function($a, $b) {
            $dateA = $a['fecha'] . ' ' . $a['hora'];
            $dateB = $b['fecha'] . ' ' . $b['hora'];
            return strcmp($dateA, $dateB);
        });

        // Group by date
        $groupedTides = [];
        foreach ($weeklyTides as $tide) {
            $date = $tide['fecha'];
            if (!isset($groupedTides[$date])) {
                $groupedTides[$date] = [
                    'date' => $date,
                    'day_name' => Carbon::parse($date)->translatedFormat('l d \d\e F'),
                    'tides' => []
                ];
            }
            $groupedTides[$date]['tides'][] = $tide;
        }

        return response()->json(array_values($groupedTides));
    }
}
