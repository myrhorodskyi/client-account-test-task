<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'last_password_reset',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function setPasswordAttribute(string $value)
    {
        $this->attributes['password'] = bcrypt($value);
        $this->attributes['last_password_reset'] = now();
    }

    /**
     * @return bool
     */
    public function activate()
    {
        $this->status = 'Active';
        return $this->save();
    }

    /**
     * @return bool
     */
    public function deactivate()
    {
        $this->status = 'Inactive';
        return $this->save();
    }

    public function getProfileUriAttribute()
    {
        return $this->attributes['profile_uri'] ?? "/profile/$this->id";
    }

    public function setProfileUriAttribute($value)
    {
        // Do with the value whatever you want
        $this->attributes['profile_uri'] = $value;
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'Active');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', 'Inactive');
    }
}
