<?php


namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as Respect;


class Validator
{
    protected $errors;

    public function validate ($reqest,array $rules)
    {
        foreach ($rules as $field => $rule){
            try {
                $rule->setName(ucfirst($field))->assert($reqest->getParam($field));
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessage();
            }
        }

        return $this;
    }
    public function failed()
    {
        return !empty($this->errors);
    }

}