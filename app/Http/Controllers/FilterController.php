<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class FilterController extends Controller
{
    public function search() {
        return Event::paginate(15);
    }
}
