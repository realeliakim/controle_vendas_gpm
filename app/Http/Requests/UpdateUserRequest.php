<?php

namespace App\Http\Requests;

use App\Rules\Cpf;
use App\Models\Section;
use App\Models\UserType;
use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email'         => ['required', 'string', 'email', 'max:100'],
            'cpf'           => ['required', 'string', 'max:14', new Cpf],
            'user_type_id'  => ['required', 'integer', new ModelExists(UserType::class, 'id')],
            'section_id'    => ['required', 'integer', new ModelExists(Section::class, 'id')],
        ];
    }
}
