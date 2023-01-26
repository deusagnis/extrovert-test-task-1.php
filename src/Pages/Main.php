<?php

namespace Extrovert\TestTask1\Pages;

use Extrovert\TestTask1\Facades\AuthEnvUser;

class Main
{
    protected array $config;

    protected string $username;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function view(){
        $authEnvUser = new AuthEnvUser($this->config['auth']);
        $this->username = $authEnvUser->auth();

        echo 'You are logged in as: ' . $this->username;
    }
}