<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
        $device = Device::with('geofences','coordinates')->first();
        $myTime = Carbon::now();
        $timeNow = $myTime->toDateTimeString();

        Storage::disk('local')->put('/TripHistory/$device->userz->name/file.txt', 'Your content here');

        // $this->info('Successfully we good to go.');
        \Log::info($device);
    }
}
