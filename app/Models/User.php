<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
        For example:
        If the field is boolean, the database will be tinyint(1)
        And we can cast it to a boolean type
    */
    protected $casts = [
        'is_admin' => 'boolean'
    ];

    public static function findByEmail($email)
    {
        return static::where(['email'=>$email])->first();
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function isAdmin()
    {
        return $this->email === 'francoacg1@gmail.com';
    }
}
