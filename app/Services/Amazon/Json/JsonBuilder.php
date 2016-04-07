<?php

namespace App\Services\Amazon\Json;

use App\Contracts\Interfaces\BuilderInterface;

class JsonBuilder implements BuilderInterface
{
    public function create($data)
    {
        return $this->_formatJson($data);
    }

    private function _formatJson($data)
    {
        $jsonData = json_encode($data);
        return $jsonData;
    }
}
