<?php

namespace App\Interfaces\Adapters;

interface AdapterInterface {
    static public function transform(array $data = []): array;
}
