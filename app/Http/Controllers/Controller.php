<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// Visu HTTP kontrolieru bāzes klase (Laravel noklusējums).
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}