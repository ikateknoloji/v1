<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_fullname',
        'phone',
        'email'
    ];

    /**
     * Get all of the companies for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    /**
     * Get all of the companyDetails for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companyDetails()
    {
        return $this->hasMany(CompanyDetail::class);
    }

    /**
     * Get all of the messages for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

}
