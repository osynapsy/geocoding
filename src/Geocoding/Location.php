<?php
namespace Osynapsy\Geocoding;

class Location
{
    public string $lat;
    public string $lng;
    public string $provider;

    public function __construct(string $lat, string $lng, string $provider)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->provider = $provider;
    }
}
