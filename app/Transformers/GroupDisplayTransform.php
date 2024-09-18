<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class GroupDisplayTransform extends TransformerAbstract
{
    public function transform($data)
    {
        $returnData = [];
        foreach ($data as $item) {
            $returnData[] = [
                'id' => $item->id,
                'name' => $item->name,
                "created_at" => $item->created_at,
                "users" => count($item->users) > 0 ? [
                    "id" => $item->users[0]->id ?? null,
                    "name" => $item->users[0]->name ?? null
                ] : "This group has no users",
                "created_by" => [
                    "id" => $item->createdBy["id"] ?? null,
                    "name" => $item->createdBy["name"] ?? null,
                ],
            ];
        }
        return [
            'data' => $returnData
        ];
    }

}
