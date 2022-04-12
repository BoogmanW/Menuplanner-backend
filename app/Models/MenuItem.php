<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = ["title", "description", "category"];


    public function days()
    {
        return $this->hasMany(Day::class);
    }
}
