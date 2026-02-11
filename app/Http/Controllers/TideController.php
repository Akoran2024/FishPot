<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class TideController extends Controller
{
    public function index()
    {
        $week = [];

        for ($i = 0; $i < 7; $i++) {

            $date = Carbon::now()->addDays($i);

            $week[] = [
                "date" => $date->toDateString(),
                "day_name" => $date->translatedFormat('l'),
                "tides" => [
                    [
                        "hora" => "03:12",
                        "tipo" => "Pleamar",
                        "altura" => rand(2,3) . "." . rand(0,9)
                    ],
                    [
                        "hora" => "09:45",
                        "tipo" => "Bajamar",
                        "altura" => rand(0,1) . "." . rand(0,9)
                    ],
                    [
                        "hora" => "15:30",
                        "tipo" => "Pleamar",
                        "altura" => rand(2,3) . "." . rand(0,9)
                    ],
                    [
                        "hora" => "21:50",
                        "tipo" => "Bajamar",
                        "altura" => rand(0,1) . "." . rand(0,9)
                    ]
                ]
            ];
        }

        return response()->json($week);
    }
}
