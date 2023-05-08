<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class TripHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trip:history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trip History is to enable the system store coordinates to a file directory for every 24 hours for every device user.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $devices = Device::with('geofences','coordinates')->get();

        //loop through all the devices
        foreach($devices as $device) 
        {
            $createdAt = Carbon::parse($device->created_at)->format('Y-m-d');
            $latLngData = $device->coordinates->where('device_id', $device->id)->select('latitude', 'longitude','updated_at','device_id')->get();
            
            $filePath = storage_path('app/public/TripHistories/'.$device->user.'/'.$device->id.'/'.$createdAt.'.txt');
            if (File::exists($filePath) && time() - filectime($filePath) < 24 * 60 * 60)
            {
                // The file exists and was created in the last 24 hours
                \Log::info('true');
                $fileName = basename($filePath);
                // \Log::info($fileName);

                //loop to the last line of the file content time
                $file_contents = fopen($filePath, 'r');
                fseek($file_contents, 0, SEEK_END);
                //position of the last byte
                $last_byte_pos = ftell($file_contents);
                rewind($file_contents);
                while(ftell($file_contents) < $last_byte_pos) {
                    $content = fgets($file_contents);
                    $data = json_decode($content, true);
                }
                \Log::info($data);
                // looping through the contents of the file
                foreach ($data as $item) {
                    $new_latitude = $device->coordinates->where('device_id', $device->id)->pluck('latitude')->first();
                    $new_longitude = $device->coordinates->where('device_id', $device->id)->pluck('longitude')->first();
                    $file_latitude = $item['latitude'];
                    $file_longitude = $item['longitude'];
                    // compare with the incoming new coordinates
                    if($new_latitude == $file_latitude || $new_longitude == $file_latitude)
                    {
                        \Log::info($device->name.' Device Position not Changed as yet');
                    }else {
                        \Log::info($device->name.' Device changed location to '.$new_latitude.' and '.$new_longitude);
                        // Open the file in append mode
                        $file = fopen($filePath, 'a');
                        fwrite($file, $latLngData."\n");
                        fclose($file);
                    }
                }
                fclose($file_contents);
            } else {
                // The file either doesn't exist or was not created in the last 24 hours, therefore we create a new file
                \Log::info('false');
                Storage::disk('local')->put('public/TripHistories/'.$device->user.'/'.$device->id.'/'.$createdAt.'.txt', $latLngData."\n");
            }

        }
    }
}
