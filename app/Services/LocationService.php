<?php

namespace App\Services;

class LocationService
{
    private $officeLat;
    private $officeLng;
    private $maxDistance;

    public function __construct()
    {
        $this->officeLat = config('office_location.latitude');
        $this->officeLng = config('office_location.longitude');
        $this->maxDistance = config('office_location.max_distance');
    }

    public function isValidLocation($latitude, $longitude)
    {
        $distance = $this->calculateDistance(
            $this->officeLat,
            $this->officeLng,
            $latitude,
            $longitude
        );

        return $distance <= $this->maxDistance;
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        return $miles * 1.609344; // Kilometre cinsinden sonuç
    }

    private function getLocationFromIP($ip)
    {
        $response = file_get_contents("http://ip-api.com/json/{$ip}");
        $data = json_decode($response, true);

        if ($data['status'] === 'success') {
            return [
                'latitude' => $data['lat'],
                'longitude' => $data['lon'],
            ];
        }

        return null;
    }

    public function isValidLocationFromIP($ip)
    {
        // Local IP kontrolü
        if ($ip === '127.0.0.1' || $ip === 'localhost') {
            return true;
        }

        $location = $this->getLocationFromIP($ip);

        if (!$location) {
            return false;
        }

        return $this->isValidLocation($location['latitude'], $location['longitude']);
    }
}
