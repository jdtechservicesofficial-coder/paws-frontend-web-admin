<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

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
        'address' => 'object',
        'kyc_data' => 'object',
        'ver_code_send_at' => 'datetime'
    ];


    public function loginLogs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id','desc');
    }
    public function tickets()
    {
        return $this->hasMany(SupportTicket::class)->orderBy('id','desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status','!=',0);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class)->where('status','!=',0);
    }

    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn (mixed $value, array $attributes) => ($attributes['first_name'] ?? '') . ' ' . ($attributes['last_name'] ?? ''),
        );
    }

    public function firstname(): Attribute
    {
        return new Attribute(
            get: fn (mixed $value, array $attributes) => $attributes['first_name'] ?? null,
            set: fn ($value) => ['first_name' => $value],
        );
    }

    public function lastname(): Attribute
    {
        return new Attribute(
            get: fn (mixed $value, array $attributes) => $attributes['last_name'] ?? null,
            set: fn ($value) => ['last_name' => $value],
        );
    }

    public function username(): Attribute
    {
        return new Attribute(
            get: fn (mixed $value, array $attributes) => $attributes['email'] ?? null, 
            set: fn ($value) => ['email' => $value],
        );
    }

    public function ev(): Attribute
    {
        return new Attribute(get: fn () => 1);
    }

    public function sv(): Attribute
    {
        return new Attribute(get: fn () => 1);
    }

    public function tv(): Attribute
    {
        return new Attribute(get: fn () => 1);
    }

    public function kv(): Attribute
    {
        return new Attribute(get: fn () => 1);
    }

    // SCOPES
    public function scopeActive()
    {
        return $this->where('status', 1)->where('is_banned', 0);
    }

    public function scopeBanned()
    {
        return $this->where('is_banned', 1);
    }

    public function scopeEmailUnverified()
    {
        return $this->whereNull('email_verified_at');
    }

    public function scopeMobileUnverified()
    {
        return $this->where('status', -1); // Fake condition to return none
    }

    public function scopeKycUnverified()
    {
        return $this->where('status', -1);
    }

    public function scopeKycPending()
    {
        return $this->where('status', -1);
    }

    public function scopeEmailVerified()
    {
        return $this->whereNotNull('email_verified_at');
    }

    public function scopeMobileVerified()
    {
        return $this->where('status', 1); // Always verified
    }

    public function scopeWithBalance()
    {
        return $this->where('id', '>', 0); // Ignore balance for now, Pawlly doesn't have it
    }

}
