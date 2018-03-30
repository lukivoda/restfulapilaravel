<?php

namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';

    const ADMIN_USER = true;
    const REGULAR_USER = false;




    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','verified','verification_token','admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'

    ];




    public function isVerified(){

        return $this->verified = USER::VERIFIED_USER;
    }


    public function isAdmin(){

        return $this->admin = USER::ADMIN_USER;
    }


//Generate a more truly "random" alpha-numeric string
   public function generateVerificationCode(){

       return str_random(40);
   }



}
