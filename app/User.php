<?php

namespace App;

use App\Model\Board;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',"contact",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // return all board associated with users 
    public function boards(){
        return $this->hasMany(Board::class,"user_id");
    }

    public static function createRecord(array $param){
        return User::create([
            "name" => $param['name'],
            "email" => $param['email'],
            "contact" => $param['contact'],
            "password" => Hash::make($param['password']),
            "status" => true
        ]);
    }

    public static function checkDuplicate($col,$val){
       return User::where($col,$val)->count();
    }
   
}
