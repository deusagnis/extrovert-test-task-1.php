<?php

namespace Extrovert\TestTask1\Pages;

use Extrovert\TestTask1\Facades\AuthEnvUser;

class Main
{
    protected array $authConfig;

    protected string $username;

    public function __construct(array $authConfig)
    {
        $this->authConfig = $authConfig;
    }

    public function view(){
        $authEnvUser = new AuthEnvUser($this->authConfig);
        $this->username = $authEnvUser->auth();

        echo include ('./src/Views/main.php');
    }
}