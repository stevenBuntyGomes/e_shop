<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Image;
use App\Mail\ChangePasswordConfirmMail;
use Mail;

class ProfileController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('checkrole');
    }

    public function editProfile(){
      return view('admin.profile.index', [
        'profile_photo' => Auth::user()->profile_photo,
      ]);
    }

    public function editProfilePost(Request $request){
      // Auth::user()->id;
      // $request->profile_name;
      // echo Auth::user()->updated_at->addDays(30);
      $request->validate([
        'profile_name' => 'required'
      ]);

      if(Auth::user()->updated_at->addDays(30) < Carbon::now()){
        // echo Carbon::now()->addDays(2);
        User::find(Auth::user()->id)->update([
          'name' => $request->profile_name
        ]);
        return back()->with('name_change_status', 'Your name is successfully changed');
      }else{
        $days_left = Carbon::now()->diffInDays(Auth::user()->updated_at->addDays(30));
        // $hours_left = Carbon::now()->diffInHours(Auth::user()->updated_at->addDays(30));
        return back()->withErrors("You can update after $days_left days.");
        // return back()->withErrors("You can update after $hours_left hours.");
      }

    }
    function passwordEditPost(Request $request){
      $request->validate([
        'password' => 'confirmed|alpha_num|min:8'
      ]);
      if(Hash::Check($request->old_password, Auth::user()->password)){
        if($request->old_password == $request->password){
          return back()->with('matching', 'old password and new password cant be same');
        }else{
          if($request->password != $request->password_confirmation){
            return back()->with('mismatch', 'the new password and confirm password doesnt match');
          }
          User::find(Auth::user()->id)->update([
            'password' => Hash::make($request->password)
          ]);
          //send a password change notification email start
          // $user_email = Auth::user()->email;
          // $user_name = Auth::user()->name;
          // Mail::to($user_email)->send(new ChangePasswordConfirmMail($user_name));
          Mail::to(Auth::user()->email)->send(new ChangePasswordConfirmMail(Auth::user()->name));
          return back()->with('password_changed', 'password changed successfully');
          //send a password change notification email end
        }
      }else{
        return back()->with('old_pass_error', 'The old password youve etered doesnt match');
      }
      //print_r($request->all());
    }
    function editProfileImage(Request $request){
      // print_r($request->change_photo);
      $request->validate([
        'change_photo' => 'required|image'
      ]);
      if($request->hasFile('change_photo')){
        // echo Auth::user()->profile_photo;
        if(Auth::user()->profile_photo != 'default.png'){
          //delete old photos
          $old_photo_location = 'public/uploads/profile_photos/' . Auth::user()->profile_photo;
          unlink(base_path($old_photo_location));
        }
        $upload_photo = $request->file('change_photo');
        $new_photo_name = Auth::user()->id . "." .$upload_photo->getClientOriginalExtension();
        $new_photo_location = 'public/uploads/profile_photos/' . $new_photo_name;
        Image::make($upload_photo)->resize(200,200)->save(base_path($new_photo_location));
        User::find(Auth::user()->id)->update([
          'profile_photo' => $new_photo_name,
        ]);
        return back()->with('photo_changed', 'profile photo changed successfully.');
      }else{
        return back()->with('no_photos_selected', 'no photos has been selected.');
      }
    }
}
