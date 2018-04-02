<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use Notifiable;
    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';
    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];




    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];



     /*inserting new records the database
       mutator:  This mutator will be automatically called when we attempt to set the value(new column) of the name(name of column) attribute on the model
     */

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    /*accessor The accessor will automatically be called by Eloquent when attempting to retrieve the value of the name(name of column) attribute
     */

     public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    /*inserting new records in the database
       mutator:  This mutator will be automatically called when we attempt to set the value(new column) of the email(name of column) attribute on the model
     */
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }


    public function isVerified()
    {
        return $this->verified == User::VERIFIED_USER;
    }


    public function isAdmin()
    {
        return $this->admin == User::ADMIN_USER;
    }

    public static function generateVerificationCode()
    {
        return str_random(40);
    }




}



