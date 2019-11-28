<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.11.2019
 * Time: 16:05
 */

namespace App\Validation\Rules;

use App\Models\UserModel;
use Respect\Validation\Rules\AbstractRule;

class MatchesPassword extends AbstractRule
{
    public $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function validate($input)
    {
        return password_verify( $input, $this->password);
    }
}