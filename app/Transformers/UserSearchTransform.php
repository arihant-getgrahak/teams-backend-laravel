<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class UserSearchTransform extends TransformerAbstract
{
    public function transform($data)
    {
        $sendData = [];
        foreach ($data as $item) {
            $sendData[] = [
                "id" => $item->id,
                "name" => $item->name,
                "email" => $item->email,
                "designation" => $item->designation,
            ];
        }
        return [
            "data" => $sendData
        ];
    }
}
