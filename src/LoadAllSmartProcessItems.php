<?php

namespace Extrovert\TestTask1;

class LoadAllSmartProcessItems
{
    protected SendApiRequest $api;
    protected int $entityTypeId;

    protected array $items;

    public function __construct(SendApiRequest $api, int $entityTypeId)
    {
        $this->api = $api;
        $this->entityTypeId = $entityTypeId;
    }

    public function load(): ?array
    {
        $this->items = [];
        $offset = 0;
        do{
            $result = $this->api->method('crm.item.list')
                ->send([
                    'entityTypeId' => $this->entityTypeId,
                    'start' => $offset
                ]);
            if (empty($result)) return null;
            $total = $result->total;
            $offset += count($result->result->items);
            $this->items = array_merge($this->items, $result->result->items);
        }while($total > count($this->items));

        return $this->items;
    }
}