<?php

namespace Extrovert\TestTask1;

class CreateDoc
{
    protected SendApiRequest $api;
    protected array $items;
    protected array $fieldsMap;
    protected array $idsPreset;

    public function __construct(SendApiRequest $api, array $items, array $fieldsMap, array $idsPreset)
    {
        $this->api = $api;
        $this->items = $items;
        $this->fieldsMap = $fieldsMap;
        $this->idsPreset = $idsPreset;
    }

    public function create(){
        $itemsFields = new CreateSmartProcessItemsFields($this->items, $this->fieldsMap);


        $result = $this->api->method('crm.documentgenerator.document.add')
            ->send(array_merge([], $this->idsPreset, $itemsFields->create()));

        return $result;
    }
}