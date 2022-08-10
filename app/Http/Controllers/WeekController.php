<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Week;
use App\Models\WeekActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Auth;
use PDF;

class WeekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function timesheet($month, $year){
        $weeks = Week::select("id", "user_id")->where("month", $month)->where("year", $year)->orderBy('date_start', 'ASC')->get();
        if(count($weeks) > 0){
            $id = [];
            foreach ($weeks as $key => $value) {
                $id[] = $value->id; 
                $user_id = $value->user_id;
            }

            $data['activities'] = WeekActivity::whereIn("week_id", $id)->where("status", "done")->get();
            $data['month'] = $month;
            $data['year'] = substr($year, 2, 2);
            $data['full_year'] = $year;
            $data['company'] = "PT Alatan Asasta Indonesia (AAI)";
            $data['project'] = "USDOJ / ICITAP Indonesia";
            $data['officer'] = getName($user_id);
            $data['position'] = getJobTitle($user_id);
            $data['total_working_days'] = count($data['activities']);
            $data['sign'] = asset('assets/images/user/'. getEsign($user_id));

            // return $data;
            // return view("pdf.timesheet", $data);

            $pdf = PDF::getFacadeRoot();
            $dompdf = $pdf->getDomPDF();
            $dompdf->setHttpContext(stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed'=> TRUE
                ],
            ]));
            return $pdf->loadview('pdf.timesheet', $data)->stream();
        }
    }

    public function index(Request $request)
    {
        //
        $month = date('n');
        $year = date('Y');
        $week = new Week;

        $data['users'] = User::all()->except(Auth::id());

        if($request->has('year') && $request->has('month')){
            $month = $request->month;
            $year = $request->year;
            if($request->has('user_id') && $request->user_id !== null){
                if($request->user_id == "all"){
                    $data['weeks'] = Week::where("month", $request->month)->where("year", $request->year)->orderBy('date_start', 'ASC')->get();
                }else{
                    $data['weeks'] = Week::where("month", $request->month)->where("year", $request->year)->where("user_id", $request->user_id)->orderBy('date_start', 'ASC')->get();
                }
            }else{
                $data['weeks'] = Week::where("month", $request->month)->where("year", $request->year)->where('user_id', Auth::user()->id)->orderBy('date_start', 'ASC')->get();
            }
            $request->flash();
        }else{
            $data['weeks'] = Week::where("month", $month)->where("year", $year)->where('user_id', Auth::user()->id)->orderBy('date_start', 'ASC')->get();
        }

        $data['month'] = $month;
        $data['year'] = $year;
        
        return view("pages.weekIndex", $data);
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
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'year' => 'required|integer',
            'month' => 'required|integer',
            'title' => 'required|string',
        ]);

        if($validator->fails()){
            return $validator->errors();
        }

        $id = Week::insertGetId($request->except('_token') + ['user_id' => Auth::user()->id]);

        for ($i=0; $i <= calculateDays($request->date_start, $request->date_end); $i++) { 
            $real_date = date('Y-m-d', strtotime($request->date_start. " + $i days"));

            $insert = new WeekActivity;
            $insert->week_id = $id;
            $insert->date_activities = $real_date;
            $insert->save();
        }

        // $insert = Week::insert($request->except('_token') + ['user_id' => Auth::user()->id]);
        // return "Sukses";
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function show(Week $week)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function edit(Week $week)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Week $week)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $find = Week::findOrFail($id);
        $find->delete();

        $activity = WeekActivity::where("week_id", $id)->delete();

        return Redirect::back();
    }
}
