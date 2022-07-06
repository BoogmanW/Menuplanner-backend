<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'time', 'comment'];
    protected $hidden = ['menu_item_id'];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
