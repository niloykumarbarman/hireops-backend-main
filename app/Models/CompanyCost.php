<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'amount',
        'description',
        'cost_date'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
