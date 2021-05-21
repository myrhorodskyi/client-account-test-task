<?php

namespace App\Http\Requests;

use App\Adapters\RegisterRequestAdapter;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'client_name' => 'required|unique:clients,client_name|max:100',
            'address1' => 'required',
            'city' => 'required|max:100',
            'state' => 'required|max:100',
            'country' => 'required|max:100',
            'zip' => 'required|max:20',
            'phone_no1' => 'required|max:20',
            'phone_no2' => 'max:20',
            'user.first_name' => 'required|max:50',
            'user.last_name' => 'required|max:50',
            'user.email' => 'required|email|unique:users,email|max:150',
            'user.password' => 'required|confirmed|max:150',
            'user.phone' => 'required|max:20',
        ];
    }

    public function validationData(): array
    {
        return RegisterRequestAdapter::transform( $this->all() );
    }
}
