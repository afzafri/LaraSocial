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
            return redirect()->route('home');
        } else {
            $user = User::create([
                    'name'          => $userSocial->getName(),
                    'nickname'      => $userSocial->getNickname(),
                    'email'         => $userSocial->getEmail(),
                    'image'         => $userSocial->getAvatar(),
                    'provider_id'   => $userSocial->getId(),
                    'provider'      => $provider,
                    'provider_token'         => (property_exists($userSocial, 'token')) ? $userSocial->token : '',
                    'provider_refresh_token' => (property_exists($userSocial, 'refreshToken')) ? $userSocial->refreshToken : '',
                    'provider_expires_in'    => (property_exists($userSocial, 'expiresIn')) ? $userSocial->expiresIn : '',
                ]);
            Auth::login($user);
            return redirect()->route('home');
        }
    }
}
