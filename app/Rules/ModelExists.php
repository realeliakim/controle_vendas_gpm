<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ModelExists implements ValidationRule
{

    protected $model;
    protected $field;
    protected $ignore;

    function __construct(string $model, string $field, $ignore = null)
    {
        $this->model = $model;
        $this->field = $field;
        $this->ignore = $ignore;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $model = explode('\\', $this->model);

        if(!$this->model::firstWhere($this->field, $value)){
            $fail(__('O id #' . $value. ' não existe na tabela ' . $model[2]));
        }
    }
}
