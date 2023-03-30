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
        $username = User::where('id', $user_id)->pluck('name')->first();
        $device = Device::where('id', $device_id)->pluck('name')->first();
        $contact = $user->contact;
        //Mail Notification
        $geofenceViolated = [
            'body' => 'Geo-Fence Violation Alert',
            'message' => 'Device '.$device.' appears to be out of the designated area which you earlier specified.',
            'url' => url('/'),
            'thankyou' => 'Take heed and make every necessary actions. Thank You'
        ];
        Notification::sendNow($user, new OutGeoFence($geofenceViolated));
        //calling SMS function
        //$smsDetails = $this->sendSMS($contact, $device, $username);

        return response()->json([
            'message' => 'The message was sent Successfully'
        ]);

    }

    public function sendSMS(Request $request)
    {
        $user_id = $request->input('user_id');
        $device_id = $request->input('device_id');
        
        $contact = User::where('id', $user_id)->pluck('contact')->first();
        $username = User::where('id', $user_id)->pluck('name')->first();
        $device = Device::where('id', $device_id)->pluck('name')->first();
        

        $basic  = new \Vonage\Client\Credentials\Basic("383ddc75", "DfzWYCld95UpRBWp");
        $client = new \Vonage\Client($basic);
        //SMS notification
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($contact, 'MCTS', 'Hello '.$username.' Device '.$device.' appears to be out of the designated area(GeoFence) which you earlier specified.')
        );
        $message = $response->current();
        if ($message->getStatus() == 0) {
            return response()->json([
                'message' => 'The message was Successfully sent'
            ]);
        } else {
            return response()->json([
                'message' => 'The message failed'
            ]);
        }

        return response()->json([
            'message' => 'The message was '.$contact.' '.$username.' '.$device.' sent Successfully'
        ]);

    }

    public function twilioSMS()
    {   
        $basic  = new \Vonage\Client\Credentials\Basic("383ddc75", "DfzWYCld95UpRBWp");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS('+256754428612', 'MCTS', 'A text message sent using the Nexmo SMS API')
        );
        $message = $response->current();

        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }

}
