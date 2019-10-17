<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;

use App\User;

class SocialController extends Controller
{
    public function redirect($provider)
    {
      return Socialite::driver($provider)->redirect();
    }

    public function Callback($provider)
    {
        $userSocial = Socialite::driver($provider)->user();

        $users = User::where(['email' => $userSocial->getEmail()])->first();

        if($users) {
            Auth::login($users);
            return redirect('/');
        } else {
            $user = User::create([
                    'name'          => $userSocial->getName(),
                    'email'         => $userSocial->getEmail(),
                    'image'         => $userSocial->getAvatar(),
                    'provider_id'   => $userSocial->getId(),
                    'provider'      => $provider,
                    'provider_token'         => $userSocial->token,
                    'provider_refresh_token' => $userSocial->refreshToken,
                    'provider_expires_in'    => $userSocial->expiresIn,
                ]);
            Auth::login($user);
            return redirect()->route('home');
        }
    }
}
