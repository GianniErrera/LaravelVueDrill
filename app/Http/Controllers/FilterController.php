<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class FilterController extends Controller
{
    public function search(Request $request) {
        dd(request());
        return Event::where('name', 'like', '%' . request('filters')->search . '%')->paginate(15);
    }

    public function searchString($perPage, $name, $page, $search) {
        return Event::where('name', 'like', '%' . $search . "%")->paginate($perPage, ['*'], $name, $page);
    }
}
