<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    /**
     * যে কলামগুলো mass assignment-এর জন্য allowed
     */
    protected $fillable = [
        'name',
        'domain',          // subdomain যেমন company.hireops.com
        // আরও যোগ করতে পারো: logo, address, phone, status ইত্যাদি
    ];

    /**
     * Tenant-এর অধীনে সব ইউজার (one-to-many)
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * ভবিষ্যতে যোগ করতে পারো:
     * - candidates()
     * - jobs()
     * - resumes() ইত্যাদি
     *
     * উদাহরণ:
     * public function candidates()
     * {
     *     return $this->hasManyThrough(Candidate::class, User::class);
     * }
     */
}
