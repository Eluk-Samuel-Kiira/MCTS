<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'user'];

    //1 device belongs to 1 user
    public function devices()
    {
        return $this->belongsTo(User::class,'user');
    }

}

