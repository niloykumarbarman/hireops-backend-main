<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'experience',
        'skills',
        'tenant_id',   // খুব জরুরি
    ];

    /**
     * অটোমেটিক tenant_id দিয়ে ফিল্টার
     */
    protected static function booted()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            // লগইন করা ইউজারের tenant_id দিয়ে ফিল্টার
            if (auth()->check()) {
                $builder->where('tenant_id', auth()->user()->tenant_id);
            }
        });

        // নতুন ক্যান্ডিডেট তৈরি করলে অটো tenant_id সেট হবে
        static::creating(function ($candidate) {
            if (auth()->check()) {
                $candidate->tenant_id = auth()->user()->tenant_id;
            }
        });
    }

    /**
     * এই ক্যান্ডিডেটের টেন্যান্ট
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function resumes()
{
    return $this->hasMany(Resume::class);
}
}
