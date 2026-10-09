<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;

try {
    // Uruchamiamy kontroler strony głównej
    $controller = new HomeController();
    $controller->index();
} catch (Exception $e) {
    echo "Wystąpił błąd krytyczny: " . $e->getMessage();
}