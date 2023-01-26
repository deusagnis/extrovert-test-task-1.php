<?php

namespace Extrovert\TestTask1\Facades;

use Extrovert\TestTask1\Auth;

class AuthEnvUser
{
    protected array $authConfig;
    protected Auth $authentication;

    public function __construct($authConfig)
    {
        $this->authConfig = $authConfig;

        $this->authentication = new Auth($authConfig['users']);
    }

    public function auth(){
        try {
            $username = $this->authentication->auth();
        } catch (\Exception $e){
            die($e->getMessage());
        }

        return $username;
    }
}