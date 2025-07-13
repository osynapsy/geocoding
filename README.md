# Osynapsy\Geocoding

Un package professionale e flessibile per la geocodifica di indirizzi da usare in contesti backend-driven.

## ✨ Caratteristiche principali

- Provider multipli: Nominatim, Google, OpenCage
- Fallback automatico
- Supporto a endpoint configurabili e chiavi API esterne
- Interfaccia `ProviderInterface`
- Completamente testabile e conforme a PSR-4

## 🔧 Installazione

```bash
composer require osynapsy/geocoding
```

## ⚡ Esempio d'uso

```php
use Osynapsy\Geocoding\Geocoder;
use Osynapsy\Geocoding\Provider\Nominatim;
use Osynapsy\Geocoding\Provider\Google;
use Osynapsy\Geocoding\Provider\OpenCage;

$geocoder = new Geocoder([
    new Nominatim(),
    new Google('GOOGLE_API_KEY'),
    new OpenCage('OPENCAGE_API_KEY')
]);

$location = $geocoder->locate('Via Roma 10, Milano');

if ($location) {
    echo $location->lat . ',' . $location->lng;
}
```

## 🧱 Implementazione di un nuovo provider

Crea una classe che implementa `ProviderInterface` e implementa:

```php
public function getCoordinates(string $address): ?Location;
```

## 📬 Contatti

Creato da [Pietro Celeste](mailto:p.celeste@qanda.cc) per il framework Osynapsy.

## ⚠ Licenza

MIT
