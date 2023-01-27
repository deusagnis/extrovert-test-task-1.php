<?php

namespace Extrovert\TestTask1\Pages;

use Extrovert\TestTask1\Facades\AuthEnvUser;
use Extrovert\TestTask1\Facades\ExportSmartProcess;

class ExportAllSmartProcessItems
{
    protected string $username;

    protected array $authConfig;
    protected array $apiConfig;
    protected array $docConfig;

    public function __construct(array $authConfig, array $apiConfig, array $docConfig)
    {
        $this->authConfig = $authConfig;
        $this->apiConfig = $apiConfig;
        $this->docConfig = $docConfig;
    }

    public function view(){
        $authEnvUser = new AuthEnvUser($this->authConfig);
        $this->username = $authEnvUser->auth();

        $exporter = new ExportSmartProcess($this->apiConfig, $this->docConfig);

        $result = $exporter->export();

        if (empty($result)) die("Не удалось выполнить экспорт");

        header('Location: '.$result->result->document->downloadUrlMachine);
        exit();
    }
}