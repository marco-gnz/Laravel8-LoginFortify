<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\SocialProfile;
use Mockery\Undefined;

class LoginController extends Controller
{

    public function redirectToProvider($driver)
    {
        $drivers = ['google'];

        if (in_array($driver, $drivers)) { //if para verificar si el driver que recibe el metodo se encuentra en el array de drivers (google, facebook, twitter, etc)
            return Socialite::driver($driver)->redirect();
        } else {
            return redirect()->route('welcome');
        }
    }

    public function handleProviderCallback($driver, Request $request)
    {
        if ($request->get('error')) {
            return redirect()->route('welcome');
        }

        $user_google = Socialite::driver($driver)->user();
        /* dd($user_google->user['name']); */

        $social_profile = SocialProfile::where('social_id', $user_google->getId())
            ->where('social_name', $driver)
            ->first();

        if (!$social_profile) {
            $user = User::where('email', $user_google->getEmail())->first();

            $appellido = isset($user_google->user['family_name']);
            if (!$user) {
                if (!$appellido) {
                    $user = User::create([
                        'name' => $user_google->user['given_name'],
                        'last_name' => NULL,
                        'email' => $user_google->getEmail()
                    ]);   
                } else {
                    $user = User::create([
                        'name' => $user_google->user['given_name'],
                        'last_name' => $user_google->user['family_name'],
                        'email' => $user_google->getEmail()
                    ]);
                }
            }
            SocialProfile::create([
                'user_id' => $user->id,
                'social_id' => $user_google->getId(),
                'social_name' => $driver,
                'social_avatar' => $user_google->getAvatar()
            ]);
        }
        auth()->login($user);

        return redirect()->route('home');
    }
}
