<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        "name",
        "password",
        "phone_number",
        "balance",
        "address"
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed'
    ];

    public function books(){
        return $this->belongsToMany(Book::class, 'borrowings')
            ->withPivot('borrowing_date', 'return_date', 'is_returned');
    }
}
