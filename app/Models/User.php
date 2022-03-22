<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable implements JWTSubject //, MustVerifyEmail
{
    use Notifiable,SearchableTrait,
        HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'title',
        'company_name',
        'email',
        'password',
        'telephone',
        'mobile',
        'address1',
        'address2',
        'town',
        'postcode',
        'country_id'
    ];

    protected $searchable = [

        'columns' => [
            'lastname' => 9,
            'company_name'=>7,
            'email' => 3,
            'mobile' => 3,
            'telephone' => 3,
            'postcode' => 5,
            'firstname'=>3,
            'address1' => 3,
            'town' => 3,
        ]
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $protected = [
        'role','password'
    ];

    protected $appends = [
       'address_html'
    ];


    public function country() {
        return $this->hasOne(Countries::class,'id','country_id');
    }


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */


    /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */


    /**
     * Get the oauth providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }



    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAddressHtmlAttribute() {

        $html = '';
        if(!empty($this->address1)) { $html .= $this->address1; }
        if(!empty($this->address2)) { $html .= '<br />'.$this->address2; }
        if(!empty($this->town)) { $html .= '<br />'.$this->town; }
        if(!empty($this->county)) { $html .= ', '.$this->county; }
        if(!empty($this->postcode)) { $html .= '<br />'.$this->postcode; }
        if($this->has('country')) { $html .= '<br />'.$this->country->name; }

        return $html;

    }
}
