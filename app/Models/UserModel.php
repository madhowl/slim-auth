<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 22.11.2019
 * Time: 14:29
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class UserModel extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'email',
        'name',
        'password',
    ];

    public function setPassword($password)
    {
        $this->update([
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }
}