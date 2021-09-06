<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class FilterController extends Controller
{

    public function searchString($perPage, $sortby, $search, $page) {
        return Event::
        where('name', 'like', '%' . $search . "%")
        ->orWhere('eventDescription', 'like', '%' . $search . "%")
        ->orderBy($sortby)
        ->paginate($perPage, ['*'], "page", $page);
    }

    public function singleDate($perPage, $sortby, $date, $page) {
        return Event:: where('date', "=", $date)
        ->orderBy($sortby)
        ->paginate($perPage, ['*'], "page", $page);
    }
}
