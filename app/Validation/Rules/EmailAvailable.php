<?php
namespace App\Validation\Rules;

use App\Models\UserModel;
use Respect\Validation\Rules\AbstractRule;


class EmailAvailable extends  AbstractRule
{
     public function validate($input)
     {
         return UserModel::where('email',$input)->count() === 0;
     }
}