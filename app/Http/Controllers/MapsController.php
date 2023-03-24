<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\GeoFence;
use Carbon\Carbon;

class MapsController extends Controller
{
    public function activate_device($id)
    {
        $device_status = Device::where('id', $id)->first();
        if($device_status->status == 1) {
            Device::where('id', $id)->update(['status' => 0]);
            return redirect()->back()->with('status', 'The Device Has Been Deactivated Successfully');
        }else {
            Device::where('id', $id)->update(['status' => 1]);
            return redirect()->back()->with('status', 'The Device Has Been Activated Successfully');
        }
    }

    public function trip_history($id)
    {
        //data to be retrieved from text file as devt proceeds
        $deviceHistory = Device::find($id);
        return view('devices.history',compact('deviceHistory'));
    }

    public function storeGeofence(Request $request)
    {
        $geojson = $request->input('geojson');
        $device_id = $request->input('device_id');

        GeoFence::updateOrInsert(['device_id' => $device_id],[
            'coordinates' => $geojson, "created_at"=> Carbon::now(), "updated_at"=> now()
        ]);
        // $place = new GeoFence();
        // $place->device_id = $device_id;
        // $place->coordinates = $geojson;
        // $place->save();

        return response()->json([
            'message' => 'GeoJSON data received and stored in database successfully'
        ]);
    }
}
