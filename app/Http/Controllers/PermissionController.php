<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        if(Auth::user()->level == "admin"){
            $data['permissions'] = Permission::orderBy('date_permission', 'ASC')->get();
        }else{
            $data['permissions'] = Permission::where("user_id", Auth::user()->id)->orderBy('date_permission', 'ASC')->get();
        }
        return view("pages.permissionIndex", $data);
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
            'date_permission' => 'required|date',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        if($validator->fails()){
            return $validator->errors();
        }

        $permission = new Permission;
        $permission->user_id = Auth::user()->id;
        $permission->date_permission = $request->date_permission;
        $permission->title = $request->title;
        $permission->description = $request->description;
        $permission->save();

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $find = Permission::findOrFail($id);
        $find->delete();

        return Redirect::back();
    }
}
