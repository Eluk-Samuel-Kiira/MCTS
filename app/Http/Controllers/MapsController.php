<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\User;
use App\Models\GeoFence;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OutGeoFence;

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

        return response()->json([
            'message' => 'GeoJSON data received and stored in database successfully'
        ]);
    }

    public function sendNotification(Request $request)
    {
        $user_id = $request->input('user_id');
        $device_id = $request->input('device_id');   
        $user = User::where('id', $user_id)->first();
        $device = Device::where('id', $device_id)->pluck('name')->first();

        //Mail Notification
        $geofenceViolated = [
            'body' => 'Geo-Fence Violation Alert',
            'message' => 'Device '.$device.' appears to be out of the designated area which you earlier specified.',
            'url' => url('/'),
            'thankyou' => 'Take heed and make every necessary actions. Thank You'
        ];
        Notification::sendNow($user, new OutGeoFence($geofenceViolated));

        //SMS notification
        // $basic  = new \Vonage\Client\Credentials\Basic("383ddc75", "DfzWYCld95UpRBWp");
        // $client = new \Vonage\Client($basic);
        // $response = $client->sms()->send(
        //     new \Vonage\SMS\Message\SMS($user->user, BRAND_NAME, 
        //     'Device '.$device.' appears to be out of the designated area which you earlier specified.\nTake heed and make every necessary actions. \nThank You')
        // );
        // $message = $response->current();
        // if ($message->getStatus() == 0) {
        //     return response()->json([
        //         'message' => 'Mail and SMS Notification Sent Successfully'
        //     ]);
        // } else {
        //     return response()->json([
        //         'message' => "The message failed with status: " . $message->getStatus() . "\n"
        //     ]);
        // }
        return response()->json([
            'message' => 'The message Successful'
        ]);

    }

}
