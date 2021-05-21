<?php

namespace App\Repositories;

use App\Http\Resources\AccountResource;
use App\Interfaces\Repositories\AccountRepositoryInterface;
use App\Models\Client;
use App\Http\Resources\AccountCollection;

class AccountRepository implements AccountRepositoryInterface {

    static public $FILTER_FIELDS = [
        'id',
        'client_name',
        'address_1',
        'address_2',
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
        'phone_n1',
        'phone_n2',
        'zip',
        'start_validity',
        'end_validity',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * @param array $data
     * @return AccountResource
     */
    public function create(array $data): AccountResource
    {
        $client = Client::create($data);
        $client->users()->create($data['user']);
        return new AccountResource($client);
    }

    /**
     * @param array $searchParams
     * @param string $orderBy
     * @param string $direction
     * @return AccountCollection
     */
    public function find(array $searchParams = [], string $orderBy = 'id', string $direction = 'asc'): AccountCollection
    {
        $query = Client::query();
        foreach ($searchParams as $key => $value) {
            $query->where($key, 'like', "%$value%");
        }
        $query->orderBy($orderBy, $direction);
        return new AccountCollection($query->simplePaginate());
    }

    /**
     *
     */
    public function all()
    {
        // TODO: Implement all() method.
    }
}
