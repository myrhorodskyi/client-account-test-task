<?php

namespace App\Http\Requests;

use App\Adapters\SearchRequestAdapter;
use App\Repositories\AccountRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // We don't need for authorization on a register request
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'integer',
            'client_name' => 'string|max:100',
            'address_1' => 'string',
            'address_2' => 'string|max:100',
            'city' => 'string|max:100',
            'state' => 'string|max:100',
            'country' => 'string|max:100',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'phone_no1' => 'string|max:20',
            'phone_no2' => 'string|max:20',
            'zip' => 'string|max:20',
            'start_validity' => 'date',
            'end_validity' => 'date',
            'status' => ['string', Rule::in('Active', 'Inactive')],
            'created_at' => 'date',
            'updated_at' => 'date',
            'order_by' => ['nullable', 'string', Rule::in(AccountRepository::$FILTER_FIELDS)],
            'direction' => ['string', Rule::in('asc', 'desc')]
        ];
    }
}
