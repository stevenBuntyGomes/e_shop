<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FinidOutNumberRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
     // ~ = start or ending [0-9] = number set ~[0-9]~ start or end wherever the number is will be notified
    public function passes($attribute, $value)
    {
        if(preg_match('~[0-9]~', $value)){
          return 0;
        }else{
          return 1;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'your input can not contain numbers.';
    }
}
