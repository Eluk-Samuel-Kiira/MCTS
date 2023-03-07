<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use File;

class StatisticsController extends Controller
{
   public function activate_user($id)
    {
        $user_status = User::where('id', $id)->first();
        if($user_status->status == 1) {
            User::where('id', $id)->update(['status' => 0]);
            return redirect()->back()->with('status', 'The User Has Been Deactivated Successfully');
        }else {
            User::where('id', $id)->update(['status' => 1]);
            return redirect()->back()->with('status', 'The User Has Been Activated Successfully');
        }
    }

    public function user_photo(Request $request)
    {
        //delete the previous one
        $user_photo = User::where('id',auth()->user()->id)->first();

        $fileloc = 'app/public/profile_photo/'.$user_photo->profile_photo_path;
        $filename = storage_path($fileloc);
        //dd($filename);

        if(File::exists($filename)) {
            File::delete($filename);
        }

        $user_photo = User::where('id',auth()->user()->id)->first();
        $image = $request->file('image');
        if($image != null) {
            $imageName = time().'.'.$image->extension();
            $image->move(storage_path('app/public/profile_photo'),$imageName);
            $user_photo->update(['profile_photo_path' => $imageName]);
        
        }

        return redirect()->route('users.index')->with('status','User Profile-Photo Updated Successfully');
    }

    public function device_owner()
    {
        return view('dashboard.device');
    }
}
