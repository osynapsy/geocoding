<?php
namespace Osynapsy\Geocoder\Provider;

use Osynapsy\Geocoder\ProviderInterface;
use Osynapsy\Geocoder\Location;

class LocationIq implements ProviderInterface
{
    private string $apiKey;
    private string $endpoint;

    public function __construct(string $apiKey, string $endpoint = 'https://us1.locationiq.com/v1/search.php')
    {
        $this->apiKey = $apiKey;
        $this->endpoint = $endpoint;
    }

    public function getCoordinates(string $address): ?Location
    {
        $url = sprintf('%s?key=%s&q=%s&format=json',
            $this->endpoint,
            urlencode($this->apiKey),
            urlencode($address)
        );

        $opts = ["http" => ["header" => "User-Agent: Osynapsy-Geocoder/1.0\r\n"]];
        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            return null;
        }

        $data = json_decode($response, true);
        if (!is_array($data) || empty($data[0]['lat']) || empty($data[0]['lon'])) {
            return null;
        }

        return new Location(
            (float) $data[0]['lat'],
            (float) $data[0]['lon'],
            'locationiq'
        );
    }
}
