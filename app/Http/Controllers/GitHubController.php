<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use Carbon\Carbon;


class GitHubController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();

        if(!User::where('email', $user->getEmail())->exists()){
            User::insert([
                'name' => $user->getNickname(),
                'email' => $user->getEmail(),
                'password' => Hash::make('abc@123'),
                'role' => 2,
                'created_at' => Carbon::now(),
            ]);
        }

      if(Auth::attempt(['email' => $user->getEmail(), 'password' => 'abc@123',])) {
          return redirect('customer/home');
      }


        // $user->token;
    }

}
