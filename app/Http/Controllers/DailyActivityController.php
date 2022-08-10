<?php

namespace App\Http\Controllers;

use App\Models\DailyActivity;
use App\Models\Week;
use App\Models\WeekActivity;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DailyActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['activities'] = DailyActivity::where("user_id", Auth::user()->id)->orderBy('date_activities', 'DESC')->get();
        return view("pages.dailyActivities", $data);
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
        $validator = Validator::make($request->all(), [
            'date_activities' => 'required|date',
            'detail_activities' => 'required|string',
        ]);

        if($validator->fails()){
            return $validator->errors();
        }

        $activity = new DailyActivity;
        $activity->user_id = Auth::user()->id;
        $activity->date_activities = $request->date_activities;
        $activity->detail_activities = $request->detail_activities;
        $activity->save();

        $weeks = Week::where("user_id", Auth::user()->id)->where("date_start", "<=", $request->date_activities)->where("date_end", ">=", $request->date_activities)->first();

        $update = WeekActivity::where("week_id", $weeks->id)
            ->where("date_activities", $request->date_activities)
            ->update([
            'realization_activities' => $request->detail_activities,
            'status' => "done",
        ]);

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DailyActivity  $dailyActivity
     * @return \Illuminate\Http\Response
     */
    public function show(DailyActivity $dailyActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DailyActivity  $dailyActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyActivity $dailyActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DailyActivity  $dailyActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'detail_activities' => 'required|string',
        ]);

        if($validator->fails()){
            return $validator->errors();
        }

        $find = DailyActivity::findOrFail($id);
        $find->detail_activities = $request->detail_activities;
        $find->save();

        $weeks = Week::where("user_id", Auth::user()->id)
                ->where("date_start", "<=", $find->date_activities)
                ->where("date_end", ">=", $find->date_activities)
                ->first();

        $update = WeekActivity::where("week_id", $weeks->id)
            ->where("date_activities", $find->date_activities)
            ->update([
            'realization_activities' => $request->detail_activities,
            'status' => "done",
        ]);

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyActivity  $dailyActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $delete = DailyActivity::findOrFail($id)->delete();
        return Redirect::back();
    }
}
