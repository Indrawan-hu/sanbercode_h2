<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\UsesUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, UsesUuid;

    protected function get_user_role_id()
    {
        $role = \App\Role::where('name', 'user')->first();
        return $role->id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($modal) {
            $modal->role_id = $modal->get_user_role_id();
        });

        static::created(function ($modal) {
            $modal->generate_otp_code();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        if ($this->role_id === $this->get_user_role_id()) {
            return false;
        }

        return true;
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }


    public function generate_otp_code()
    {
        do {
            $rand = rand(100000, 999999);
            $otp = OtpCode::where('otp', $rand)->first();
        } while ($otp);

        OtpCode::updateOrCreate(
            ["user_id" => $this->id],
            ["otp" => $rand, "valid_until" => Carbon::now()->addMinutes(5)]
        );
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
