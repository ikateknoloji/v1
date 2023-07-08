<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = [
        'district',
        'city_id',
    ];

    /**
     * Get the city that owns the district.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the company details for the district.
     */
    public function companyDetails()
    {
        return $this->hasMany(CompanyDetail::class);
    }
}
