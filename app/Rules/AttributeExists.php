<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AttributeExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param Model $model
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $model::has($attribute);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The attribute not exists in database';
    }
}
