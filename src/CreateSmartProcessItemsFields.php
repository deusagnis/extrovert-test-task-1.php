<?php

namespace Extrovert\TestTask1;

class CreateSmartProcessItemsFields
{
    protected array $items;
    protected array $fieldsMap;

    public function __construct(array $items, array $fieldsMap)
    {
        $this->items = $items;
        $this->fieldsMap = $fieldsMap;
    }

    public function create(): array
    {
        return [
            'providerClassName' => '\\Bitrix\\DocumentGenerator\\DataProvider\\Rest',
            'value' => 1,
            'values' => $this->createTableValues(),
            'fields' => [
                'Table' => [
                    'PROVIDER' => 'Bitrix\\DocumentGenerator\\DataProvider\\ArrayDataProvider',
                    'OPTIONS' => [
                        'ITEM_NAME' => 'Item',
                        'ITEM_PROVIDER' => 'Bitrix\\DocumentGenerator\\DataProvider\\HashDataProvider',
                    ],
                ],
            ],
        ];
    }

    protected function createTableValues(): array
    {
        $values = [
            'Table' => array_map(function ($item) {
                $res = [];
                foreach ($this->fieldsMap as $fieldName) {
                    $res[] = $item->{$fieldName};
                }
                return $res;
            }, $this->items),
            'TableIndex' => 'Table.INDEX',
        ];
        $fieldIndex = 0;
        foreach ($this->fieldsMap as $templateKey => $fieldName) {
            $values[$templateKey] = 'Table.Item.' . $fieldIndex;
            $fieldIndex++;
        }
        return $values;
    }
}