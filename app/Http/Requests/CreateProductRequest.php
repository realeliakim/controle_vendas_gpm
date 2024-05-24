<?php

namespace App\Http\Requests;

use App\Models\Section;
use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name'         => ['required', 'string', 'max:200'],
            'price'        => ['required', 'min:0'],
            'stock'        => ['required', 'integer', 'min:0'],
            'section_id'   => ['required', 'integer', new ModelExists(Section::class, 'id')],
        ];
    }
}
