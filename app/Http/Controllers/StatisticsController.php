<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function all_users()
    {
        $all_users = DB::table('users')->get();
        return view('dashboard.users',compact('all_users'));
    }
}
