<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Company extends Model
{
    use HasFactory;

    protected $fillable = [
    'name',
    'email',
    'phone',
    'tenant_id',
];

public function tenant()
{
    return $this->belongsTo(Tenant::class);
}

    // One company has many users
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function employees()
{
    return $this->hasMany(Employee::class);
}

}
