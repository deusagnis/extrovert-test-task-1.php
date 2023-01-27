<?php

namespace Extrovert\TestTask1\Facades;

use Extrovert\TestTask1\CreateDoc;
use Extrovert\TestTask1\LoadAllSmartProcessItems;
use Extrovert\TestTask1\SendApiRequest;

class ExportSmartProcess
{
    protected SendApiRequest $api;
    protected array $idsPreset;
    protected array $fieldsMap;

    public function __construct($apiConfig, $docConfig){
        $this->api = new SendApiRequest($apiConfig['entryUrl']);
        $this->idsPreset = $docConfig['idsPreset'];
        $this->fieldsMap = $docConfig['fieldsMap'];
    }

    public function export() {
        $loader = new LoadAllSmartProcessItems($this->api, $this->idsPreset['entityTypeId']);
        $items = $loader->load();

        $creator = new CreateDoc($this->api, $items, $this->fieldsMap, $this->idsPreset);
        return $creator->create();
    }
}