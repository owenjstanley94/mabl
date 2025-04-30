<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    protected $fillable = ['name', 'email', 'licence_number', 'role', 'level'];
}
