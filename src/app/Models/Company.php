<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'logo_path',
        'address',
        'description',
        'website',
        'contact_email',
        'contact_phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}