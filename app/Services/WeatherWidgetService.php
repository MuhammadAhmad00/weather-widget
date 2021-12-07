<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Facades\Location;

class WeatherWidgetService
{
    public $baseUrl = "api.openweathermap.org/data/2.5/weather";
    public $endUrl = "";
    public function getUserCurrentLocation($lat = null, $lon = null, $unit)
    {
        $data = [];
        $endpoint = "&appid=" . env('OPEN_WEATHER_API', null);
        $currentLocData = @unserialize(file_get_contents('http://ip-api.com/php/'));
        if (is_null($lat) && is_null($lon)) {

            if ($currentLocData && $currentLocData["status"] == "success") {

                $locData = [
                    "lat" => $currentLocData["lat"],
                    "lon" =>  $currentLocData["lon"],
                ];
            } else {

                $ip = request()->ip();
                $currentLocData = Location::get($ip);
                if ($currentLocData) {
                    $locData = [
                        "lat" => $currentLocData->latitude,
                        "lon" =>  $currentLocData->longitude,
                    ];
                }
            }
        } else {
            $locData = [
                "lat" => $lat,
                "lon" =>  $lon,
            ];
        }
        if (isset($locData["lat"]) && isset($locData["lon"])) {
            $apiUlr = $this->baseUrl . "?lat=" . $locData["lat"] . '&lon=' . $locData["lon"] . $endpoint . '&units=' . $unit;
            $response = Http::get($apiUlr);
            $data = json_decode($response->body(), true);
            $data["air_quality"] = $this->getAirPollution($locData["lat"], $locData["lon"], $endpoint);
        }
        return $data;
    }
    private function getAirPollution($lat, $lon, $endpoint)
    {
        $apiUlr = 'http://api.openweathermap.org/data/2.5/air_pollution' . "?lat=" . $lat . '&lon=' . $lon . $endpoint;
        $response = Http::get($apiUlr);
        $data = json_decode($response->body(), true);


        if (isset($data['list'][0]['main']['aqi'])) {
            return $this->getAirQuality($data['list'][0]['main']['aqi']);
        } else {
            return "None";
        }
    }

    private function getAirQuality($index)
    {
        if ($index == 1) {
            return "Good";
        } elseif ($index == 2) {
            return "Fair";
        } elseif ($index == 3) {
            return "moderate";
        } elseif ($index == 4) {
            return "Poor";
        } else {
            return "Very Poor";
        }
    }
}
