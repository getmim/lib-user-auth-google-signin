<?php
/**
 * GoogleLogin
 * @package lib-user-auth-google-signin
 * @version 0.0.1
 */

namespace LibUserAuthGoogleSignin\Library;

use Google\Client;
use LibUserAuthGoogleSignin\Model\GoogleSignin;
use LibUser\Library\Fetcher as User;

class GoogleLogin
{

    public static function assignUser(object $user, string $google_user): void
    {
        $exists = GoogleSignin::getOne([
            'user' => $user->id,
            'google_user' => $google_user
        ]);
        if($exists)
            return;

        GoogleSignin::create([
            'user' => $user->id,
            'google_user' => $google_user
        ]);
    }

    public static function getUser(string $token): ?object
    {
        $client_id = \Mim::$app->config->libUserAuthGoogleSignin->client->id;
        $client = new Client(['client_id' => $client_id]);

        $payload = $client->verifyIdToken($token);

        if(!$payload)
            return null;

        if($payload['aud'] != $client_id)
            return null;

        $google_user = $payload['sub'];

        $user = null;

        $g_user = GoogleSignin::getOne(['google_user' => $google_user]);
        if($g_user)
            $user = User::getOne(['id' => $g_user->user]);

        $result = (object)[
            'google' => (object)[
                'id' => $google_user,
                'email' => (object)[
                    'address'  => $payload['email'] ?? null,
                    'verified' => $payload['email_verified'] ?? false
                ],
                'name' => $payload['name'],
                'avatar' => $payload['picture']
            ],
            'user'   => $user
        ];

        return $result;
    }
}
