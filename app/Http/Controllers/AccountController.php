<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SearchAccountRequest;
use App\Interfaces\Repositories\AccountRepositoryInterface;
use App\Repositories\AccountRepository;
use Symfony\Component\HttpFoundation\ParameterBag;

class AccountController extends Controller
{
    /**
     * @var AccountRepositoryInterface
     */
    private $repository;

    /**
     * AccountController constructor.
     * @param AccountRepositoryInterface $repository
     */
    public function __construct(AccountRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param RegisterRequest $request
     * @return mixed
     */
    public function create(RegisterRequest $request) {
        $data = $request->validated();
        return $this->repository->create($data);
    }

    /**
     * @param SearchAccountRequest $request
     * @return mixed
     */
    public function index(SearchAccountRequest $request) {
        $searchFields = $request->only(AccountRepository::$FILTER_FIELDS);
        $orderBy = $request->query('order_by') ?? 'id';
        $direction = $request->query('direction') ?? 'asc';

        return $this->repository->find(
            $searchFields,
            $orderBy,
            $direction
        );
    }
}
