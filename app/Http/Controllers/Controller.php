<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;


#[OA\Info(title: "Perpustakaan Penus API", version: "1.0.0")]
#[OA\License(name: "MIT", url: "https://opensource.org/licenses/MIT")]
#[OA\Contact(name: "Dimas Maulana Ishaq", email: "dimasmaulanaishaq@example.com")]
#[OA\Server(url: 'http://localhost:8000', description: 'Development Server')]

abstract class Controller
{
    //
}
