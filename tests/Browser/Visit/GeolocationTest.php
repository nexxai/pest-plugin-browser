<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Pest\Browser\Enums\Cities;

test('can set geolocation', function (): void {
    Route::get('/', fn (): string => '
        <html>
        <head></head>
        <body>
            <div>Location:</div>
            <div id="coordinates">
                <span id="latitude">Waiting...</span>
                <span id="longitude">Waiting...</span>
            </div>
            <script>
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById("latitude").textContent = position.coords.latitude;
                    document.getElementById("longitude").textContent = position.coords.longitude;
                });
            </script>
        </body>
        </html>
    ');

    $latitude = 51.5074;
    $longitude = -0.1278;

    visit('/')
        ->geolocation($latitude, $longitude)
        ->assertSeeIn('#latitude', (string) $latitude)
        ->assertSeeIn('#longitude', (string) $longitude)
        ->assertDontSee('Waiting...');
});

test('can set geolocation using Cities enum', function (): void {
    Route::get('/', fn (): string => '
            <html>
            <head></head>
            <body>
                <div>Location:</div>
                <div id="coordinates">
                    <span id="latitude">Waiting...</span>
                    <span id="longitude">Waiting...</span>
                </div>
                <script>
                    navigator.geolocation.getCurrentPosition(function(position) {
                        document.getElementById("latitude").textContent = position.coords.latitude;
                        document.getElementById("longitude").textContent = position.coords.longitude;
                    });
                </script>
            </body>
            </html>
        ');

    $city = Cities::LONDON;
    $expectedLatitude = $city->geolocation()['latitude'];
    $expectedLongitude = $city->geolocation()['longitude'];

    visit('/')
        ->geolocation($city)
        ->assertSeeIn('#latitude', (string) $expectedLatitude)
        ->assertSeeIn('#longitude', (string) $expectedLongitude)
        ->assertDontSee('Waiting...');
});

test('throws an error if latitude is provided without longitude', function (): void {
    visit('/')
        ->geolocation(0.0);
})->throws(InvalidArgumentException::class, 'Longitude must be provided when latitude is specified')->only();
