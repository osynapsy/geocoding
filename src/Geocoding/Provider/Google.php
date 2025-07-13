<?php
namespace Osynapsy\Geocoding\Provider;

use Osynapsy\Geocoding\Location;

class Google implements ProviderInterface
{
    private string $apiKey;
    private string $endpoint;

    public function __construct(string $apiKey, string $endpoint = 'https://maps.googleapis.com/maps/api/geocode/json')
    {
        $this->apiKey = $apiKey;
        $this->endpoint = $endpoint;
    }

    public function getCoordinates(string $address): ?Location
    {
        $url = sprintf('%s?address=%s&key=%s', $this->endpoint, urlencode($address), $this->apiKey);
        $response = @file_get_contents($url);
        $data = json_decode($response, true);

        if (empty($data['results'][0]['geometry']['location'])) {
            return null;
        }

        $loc = $data['results'][0]['geometry']['location'];
        return new Location($loc['lat'], $loc['lng'], 'google');
    }
}
