<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'city',
    ];

    /**
     * Get the districts for the city.
     */
    public function districts()
    {
        return $this->hasMany(District::class);
    }
    
    /**
     * Get the company details for the city.
     */
    public function companyDetails()
    {
        return $this->hasMany(CompanyDetail::class);
    }
}
