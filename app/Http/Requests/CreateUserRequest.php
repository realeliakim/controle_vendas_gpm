<?php

namespace App\Http\Requests;

use App\Rules\Cpf;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:200'],
            'email'         => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'cpf'           => ['required', 'string', 'max:14', 'unique:users,cpf', new Cpf],
            'user_type_id'  => ['required', 'integer'],
            'section_id'    => ['required', 'integer'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
