<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::get();
        return view('admin.settings', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function saveSettings(Request $request)
    {
        $request->validate([
            "panel_name" => "required"
        ]);
        $setting = Setting::all();
        $path = $setting[0]->logo;
        if($request->hasFile('logo')){
            $path = storage_path('app/public/'.$setting[0]->logo); 
            if(file_exists($path)){
                @unlink($path);
                $path = $request->file('logo')->store('settings' , "public");
            }
        }
        $save_udpate = $setting[0]->update([
            "panel_name" => $request->panel_name,
            "logo" => $path
        ]);
        if($save_udpate){
            return back()->with('settings_update', 'Settings updated successfully');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
