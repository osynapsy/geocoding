<?php
namespace Osynapsy\Geocoding\Provider;

use Osynapsy\Geocoding\Location;

/**
 * Description of Here
 *
 * @author Pietro Celeste <p.celeste@osynapsy.net>
 */
class Here implements ProviderInterface
{
    private string $apiKey;
    private string $endpoint;

    public function __construct(string $apiKey, string $endpoint = 'https://geocode.search.hereapi.com/v1/geocode')
    {
        $this->apiKey = $apiKey;
        $this->endpoint = $endpoint;
    }

    public function getCoordinates(string $address): ?Location
    {
        $url = sprintf('%s?q=%s&apiKey=%s',
            $this->endpoint,
            urlencode($address),
            urlencode($this->apiKey)
        );

        $opts = ["http" => ["header" => "User-Agent: Osynapsy-Geocoder/1.0\r\n"]];
        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            return null;
        }

        $data = json_decode($response, true);
        if (empty($data['items'][0]['position']['lat']) || empty($data['items'][0]['position']['lng'])) {
            return null;
        }

        return new Location(
            (float) $data['items'][0]['position']['lat'],
            (float) $data['items'][0]['position']['lng'],
            'here'
        );
    }
}