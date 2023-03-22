<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

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
}
