<?php
namespace Osynapsy\Geocoding\Provider;

use Osynapsy\Geocoding\Location;

class Nominatim implements ProviderInterface
{
    private string $endpoint;

    public function __construct(string $endpoint = 'https://nominatim.openstreetmap.org/search?format=json&q=')
    {
        $this->endpoint = $endpoint;
    }

    public function getCoordinates(string $address): ?Location
    {
        $url = $this->endpoint . urlencode($address);
        $context = stream_context_create([
            "http" => [
                "header" => "User-Agent: Osynapsy-Geocoder/1.0\r\n"
            ]
        ]);
        $response = @file_get_contents($url, false, $context);
        $data = json_decode($response, true);

        sleep(1);

        if (empty($data)) {
            return null;
        }

        return new Location($data[0]['lat'], $data[0]['lon'], 'nominatim');
    }
}
