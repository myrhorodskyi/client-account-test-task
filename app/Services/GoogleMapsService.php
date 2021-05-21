<?php

namespace App\Services;

class GoogleMapsService {
    public function getCoordinatesByAddress(string $address)
    {
        return \Cache::rememberForever($address, function () use ($address) {
            try {
                $response = \GoogleMaps::load('geocoding')
                    ->setParam(['address' => $address])
                    ->get();
                $data = json_decode($response, true);
                $coords = $data['results'][0]['geometry']['location'];
                return $coords;
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                return [];
            }
        });
    }
}
