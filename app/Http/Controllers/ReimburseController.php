<?php

namespace App\Http\Controllers;

use App\Models\DetailReimburse;
use App\Models\Reimburse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReimburseController extends Controller
{
    //
    public function index()
    {

        if (auth()->user()->level == 'admin' || auth()->user()->level == 'manager') {
            $data = Reimburse::with('approver', 'submitted', 'detailReimburse')->get();
        } else {
            $data = Reimburse::with('approver', 'submitted', 'detailReimburse')->where('submitted_id', auth()->user()->id)->get();
        }

        // dd($data);
        return view('pages.reimburse.index', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'date_purchase' => 'required',
            'category' => 'required',
            'description_purchase' => 'required',
            'amount' => 'required',
            'file' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
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
            $file->move(public_path('uploads/reimburse'), $fileName);
        } else {
            $fileName = null;
        }

        // dd($request->all());

        DB::beginTransaction();

        try {
            //code...
            $reimburse = Reimburse::create([
                "date_purchase" => $request->date_purchase,
                "category" => $request->category,
                "amount" => $request->amount,
                "path_file" => $fileName,
                "approver_id" => null,
                "submitted_id" => auth()->user()->id,
                "description_purchase" => $request->description_purchase,
            ]);

            for ($i = 0; $i < count($request->product_name); $i++) {
                DetailReimburse::create([
                    "reimburse_id" => $reimburse->id,
                    "product_name" => $request->product_name[$i],
                    "price" => $request->price[$i],
                ]);
            }

            $modal = [
                "modal" => "yes",
                "modal_title" => "Success!",
                "modal_message" => "Your request has been sent to the approver",
                "modal_type" => "success",
            ];
            DB::commit();
            return back()->with($modal);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            $modal = [
                "modal" => "yes",
                "modal_title" => "Ups! Sorry..",
                "modal_message" => $th->getMessage(),
                "modal_type" => "error",
            ];
            return back()->with($modal);
        }
    }

    public function approved($reimburse_id)
    {
        $reimburse = Reimburse::find($reimburse_id);
        $reimburse->update([
            "approver_id" => auth()->user()->id,
            "status" => "approved"
        ]);

        $modal = [
            "modal" => "yes",
            "modal_title" => "Success!",
            "modal_message" => "Reimburse has been approved",
            "modal_type" => "success",
        ];
        return back()->with($modal);
    }

    public function rejected($reimburse_id)
    {
        $reimburse = Reimburse::find($reimburse_id);
        $reimburse->update([
            "approver_id" => auth()->user()->id,
            "status" => "rejected"
        ]);

        $modal = [
            "modal" => "yes",
            "modal_title" => "Success!",
            "modal_message" => "Reimburse has been rejected",
            "modal_type" => "success",
        ];
        return back()->with($modal);
    }
}
