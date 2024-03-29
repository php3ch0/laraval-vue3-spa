<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable,SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'telephone',
        'email',
        'password',
        'address1',
        'address2',
        'town',
        'postcode'
    ];

    protected $searchable = [

        'columns' => [
            'firstname'=>'6',
            'lastname' => 10,
            'email' => 10
        ]
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at'
    ];

    protected $guarded =[
        'role'
    ];

    protected $appends = [
      'two_factor'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getTwoFactorAttribute() {
       return $this->hasEnabledTwoFactorAuthentication();
    }
    
}
