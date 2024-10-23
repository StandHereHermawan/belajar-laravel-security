<?php

namespace App\Providers\Model\User;

use Illuminate\Auth\GenericUser;

class SimpleUserProvider implements \Illuminate\Contracts\Auth\UserProvider
{

    private GenericUser $genericUser;


    public function __construct()
    {
        $this->genericUser = new GenericUser([
            "id" => "terryinparis",
            "name" => "Terry In Paris",
            "token" => "sample-token-terry",
        ]);
    }

    function retrieveByCredentials(array $credentials)
    {
        if ($credentials['token'] == $this->genericUser->__get('token')) {
            return $this->genericUser;
        }
        return null;
    }

    function retrieveById($identifier)
    {
        if ($identifier == $this->genericUser['id']) {
            return $this->genericUser;
        }
        return null;
    }

    function retrieveByToken($identifier, $token)
    {
        if ($identifier == $this->genericUser['id'] && $token == $this->genericUser['token']) {
            return $this->genericUser;
        }
        return null;
    }

    function updateRememberToken(\Illuminate\Contracts\Auth\Authenticatable $user, $token)
    {
        
    }

    function validateCredentials(\Illuminate\Contracts\Auth\Authenticatable $user, array $credentials)
    {
    }
}
