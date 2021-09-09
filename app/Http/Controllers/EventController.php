<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($filters, $perPage, $page = 1)
    {
        $query_filters = json_decode($filters);


        return Event::where('name', 'like', '%' . $query_filters->search . "%")
            ->orWhere('eventDescription', 'like', '%' . $query_filters->search . "%")
            ->singleDateQuery($query_filters->ignore_year_from_query, $query_filters->single_date)
            ->dateRangeQuery($query_filters->ignore_year_from_query, $query_filters->start_date, $query_filters->end_date)
            ->orderBy($query_filters->selected, 'desc')
            ->paginate($perPage, ['*'], "page", $page);

    }


    /**
     * Returns upcoming events or yesterday events
     *
     * @return \Illuminate\Http\Response
     */
    public function reminders()
    {
       return Event::
        where('date', '>=', Carbon::yesterday())->
        where('date', '<=', Carbon::today()->addDays(30))->
        orderBy('date')->
        take(10)->
        get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)    {
        $event = new Event();
        $event->name = $request->input('name');
        $event->eventDescription = $request->input('description');
        $event->date = $request->input('date');
        $event->isItRecurringYearly = $request->input('isItYearly');
        $event->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
