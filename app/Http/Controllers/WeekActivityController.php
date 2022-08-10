<?php

namespace App\Http\Controllers;

use App\Models\Week;
use App\Models\WeekActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class WeekActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $data['id'] = $id;
        $data['wp'] = Week::findOrFail($id);
        $data['weeks_activity'] = WeekActivity::where("week_id", $id)->orderBy('date_activities', 'ASC')->get();
        return view("pages.weeks_activity", $data);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WeekActivity  $weekActivity
     * @return \Illuminate\Http\Response
     */
    public function show(WeekActivity $weekActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WeekActivity  $weekActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(WeekActivity $weekActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WeekActivity  $weekActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        foreach ($request->date_activities as $key => $date_activities) {
            $update = WeekActivity::where("id", $key)->update([
                'date_activities' => $request->date_activities[$key],
                'days_worked' => $request->days_worked[$key],
                'place' => $request->place[$key],
                'plan_activities' => $request->plan_activities[$key],
                'time_start' => $request->time_start[$key],
                'realization_activities' => $request->realization_activities[$key],
                'time_end' => $request->time_end[$key],
                'status' => $request->status[$key],
                'evidance_link' => $request->evidance_link[$key],
            ]);
        }

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WeekActivity  $weekActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
