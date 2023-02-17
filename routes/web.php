<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatisticsController;
use App\Models\Visitor;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $visited_time = now()->format('H:i:s');
        $visited_date = now()->format('Y-m-d');
        $ip = \Request::getClientIp();

        $increase = Visitor::where('ip', $ip)->value('visits');
        $increase = $increase+1;
        $vistor = Visitor::updateOrInsert(['ip' => $ip],[
            'visits' => $increase, 'visited_time' => $visited_time, 'visited_date' => $visited_date
        ]);
    return view('landing_page.home');
});



//protected routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        $session_count = DB::table('sessions')->count();
        $unique_vistors = Visitor::where('visited_date', '>=', Carbon::now()->subDays(2))->count();
        $user_count = DB::table('users')->count();
        //Active users
        $users_in_session = DB::table('sessions')->value('user_id');
        $registered_users = DB::table('users')->where('id',$users_in_session)->get();
        return view('dashboard.dashboard', compact('session_count','unique_vistors','user_count','registered_users'));
    })->name('dashboard');

    Route::get('/registered/users', [StatisticsController::class, 'all_users'])->name('registered_users');;
});
