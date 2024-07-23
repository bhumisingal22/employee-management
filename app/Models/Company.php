<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'website',
    ];

    public function employees()
    {
        // Define a one-to-many relationship between Company and Employee
        return $this->hasMany(Employee::class);
    }
}
