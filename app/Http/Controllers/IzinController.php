<?php

namespace App\Http\Controllers;

use App\Models\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IzinController extends Controller
{
    //
    public function index()
    {
        // dd(auth()->user());
        if (auth()->user()->level == 'admin') {
            $data = Mail::with('user')->get();
            // return view('pages.izin.index', [
            //     'data' => $data
            // ]);
        } else {
            $data = Mail::with('user')->where('user_id', auth()->user()->id)->get();
        }

        return view('pages.izin.index', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
            'category' => 'required',
            'file' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            $modal = [
                "modal" => "yes",
                "modal_title" => "Ups! Sorry..",
                "modal_message" => $validator->errors()->first(),
                "modal_type" => "error",
            ];
            return redirect()->back()->with($modal);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/izin'), $fileName);
        } else {
            $fileName = null;
        }


        // dd($fileName);
        Mail::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'category' => $request->category,
            'path_file' => $fileName,
            'user_id' => auth()->user()->id,
        ]);

        $modal = [
            "modal" => "yes",
            "modal_title" => "Great ...!",
            "modal_message" => "Your request has been submitted",
            "modal_type" => "success",
        ];

        return back()->with($modal);
    }

    public function approved($mail_id)
    {
        $mail = Mail::find($mail_id);

        $mail->update([
            'status' => 'approved'
        ]);

        $modal = [
            "modal" => "yes",
            "modal_title" => "Great ...!",
            "modal_message" => "Your request has been approved",
            "modal_type" => "success",
        ];

        return back()->with($modal);
    }
    public function rejected($mail_id)
    {
        $mail = Mail::find($mail_id);

        $mail->update([
            'status' => 'rejected'
        ]);

        $modal = [
            "modal" => "yes",
            "modal_title" => "Great ...!",
            "modal_message" => "Your request has been Rejected",
            "modal_type" => "success",
        ];

        return back()->with($modal);
    }
}
