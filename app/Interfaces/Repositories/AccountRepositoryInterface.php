<?php

namespace App\Interfaces\Repositories;

interface AccountRepositoryInterface extends RepositoryInterface {
    public function create(array $data);

    public function find(array $searchParams = [], string $orderBy = '', string $direction = '');
}
