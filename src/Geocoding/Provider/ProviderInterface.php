<?php
namespace Osynapsy\Geocoding\Provider;

use Osynapsy\Geocoding\Location;

interface ProviderInterface
{
    public function getCoordinates(string $address): ?Location;
}
