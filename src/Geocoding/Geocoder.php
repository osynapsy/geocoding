<?php
namespace Osynapsy\Geocoding;

class Geocoder
{
    protected array $providers;

    public function __construct(array $providers = [])
    {
        $this->providers = $providers;
    }

    public function locate(string $address): ?Location
    {
        foreach ($this->providers as $provider) {
            $location = $provider->getCoordinates($address);
            if ($location) {
                return $location;
            }
        }
        return null;
    }
}
